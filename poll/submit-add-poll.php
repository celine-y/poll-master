<?php
include('../php/my_connect.php');

$questionName = $_POST['q_name'];
$options = json_decode($_POST['options']);
$groupId = $_POST['groupId'];
$tags = json_decode($_POST['tags']);
$urgency = $_POST['urgency'];

$everything_ok = true;
$err_message;

$con = cy_conn();

//INSERT QUESTION
$checkProExists = 'SELECT ROUTINE_NAME
FROM INFORMATION_SCHEMA.ROUTINES
WHERE ROUTINE_TYPE="PROCEDURE"
  AND ROUTINE_NAME="AddNewPoll"';

$query = mysqli_query($con, $checkProExists);
$proExist = (mysqli_num_rows($query) > 0) ? true: false;

if(!$proExist){
    $strCreateProcedure = "
    DROP PROCEDURE IF EXISTS AddNewPoll;
    DELIMITER |
    CREATE PROCEDURE AddNewPoll (
        IN qName VARCHAR(200),
        IN urgency INT,
        OUT sid INT
    )
    BEGIN
    INSERT INTO survey(sid, question,cid) VALUES (DEFAULT, qName, urgency);
    SET sid = LAST_INSERT_ID();
    END;
    |
    DELIMITER ;
    ";

    if (!$con->query($strCreateProcedure)){
        $everything_ok = false;
        $err_message = "Error creating AddNewPoll procedure";
    }
}
$con->close();

$sid = insertQuestionName($questionName, $urgency);
if ($sid >= 0){
    insertOptions($sid, $options);
    insertGroup($sid, $groupId);
    insertTags($tags, $sid);
}
else {
    $everything_ok = false;
    $err_message = "SID is < 0";
}

if ($everything_ok)
    {
        header('Content-Type: application/json');
        print json_encode($everything_ok);
    }
else
    {
        header('HTTP/1.1 500 Internal Server Booboo');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => $err_message, 'code' => 1337)));
    }

function insertOptions($sid, $options){
    $con = cy_conn();
    foreach($options as $option){
        $strInsertOptn = "INSERT INTO options (oid, sid, options)
            VALUES (DEFAULT, ?, ?)";
        $query = $con->prepare($strInsertOptn);
        $query->bind_param("is", $sid, $option);

        $query->execute();

        if($query->errno){
            $everything_ok = false;
            $err_message = "Error Inserting Options";
        }            
    }
    $con->close();
    $query->close();
}

function insertGroup($sid, $groupId){
    $con = cy_conn();
    $strGroup = "INSERT INTO groupsurvey (gid, sid)
        VALUES (?,?)";
    $query = $con->prepare($strGroup);
    $query->bind_param("ii", $groupId, $sid);
    $query->execute();

    if($query->errno){
        $everything_ok = false;
        $err_message = "Error Inserting Group";
    }
    $con->close();
    $query->close();
}

function insertTags($tags, $sid){
    $con = cy_conn();
    $strProdExist = 'SELECT ROUTINE_NAME
        FROM INFORMATION_SCHEMA.ROUTINES
        WHERE ROUTINE_TYPE="PROCEDURE"
        AND ROUTINE_NAME="AddTag"';
    $query = mysqli_query($con, $strProdExist);
    $procedureExist = (mysqli_num_rows($query) > 0) ? true: false;

    if (!$procedureExist){
        $strCreateProcedure="DROP PROCEDURE IF EXISTS AddTag;
        DELIMITER |
        CREATE PROCEDURE AddTag (
            IN tagName VARCHAR(25),
            IN sid INT
            )
        BEGIN
            DECLARE tagId INT;
            IF NOT EXISTS (SELECT tid FROM tags WHERE tname = tagName) THEN
            	BEGIN
                    INSERT INTO tags(tid, tname) VALUES (DEFAULT, tagName);
                    SET tagId = LAST_INSERT_ID();
               	END;
            ELSE
            	BEGIN
                	SET tagId = (SELECT tid FROM tags WHERE tname = tagName);
                END;
            END IF;
            INSERT INTO surtags(sid, tid) VALUES (sid,tagId);
        END;
        |
        DELIMITER ;";
        if (!$con->query($strCreateProcedure)){
            $everything_ok = false;
            $err_message = "Error creating AddTag procedure";
        }
    }

    $formTags = array();
    
    $i = 0;
    foreach($tags as $tag){
        if(strlen($tag) > 0){
            $formTags[$i] = trim($tag);
            $i++;
        }
    }

    // running AddTag
    foreach($formTags as $tagName){
        $call = mysqli_prepare($con, 'CALL AddTag(?, ?)');
        $call->bind_param('si', $tagName, $sid);
        $call->execute();
    }

    $con->close();
}

function insertQuestionName($questionName, $urgency){
    $con = cy_conn();

    $call = mysqli_prepare($con, 'CALL AddNewPoll(?, ?, @sid)');
    $call->bind_param('si', $questionName, $urgency);
    $call->execute();

    $select = $con->query('SELECT @sid');
    $result = $select->fetch_assoc();
    $sid = $result['@sid'];
    
    $con->close();
    $call->close();
    $select->close();

    return $sid;
}


?>