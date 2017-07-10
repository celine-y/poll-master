<?php
include('../php/my_connect.php');

$questionName = $_POST['q_name'];
$options = json_decode($_POST['options']);
$groupId = $_POST['groupId'];
$tags = json_decode($_POST['tags']);

$con = cy_conn();

echo json_encode($options);
//INSERT QUESTION
//RETURN SurveyId to INSERT Options
$strCreateProcedure = "
    CREATE PROCEDURE AddNewPoll (
        IN question VARCHAR(200),
        OUT sid INT
        )
        BEGIN
            INSERT INTO survey  (sid, question, cid
        END
    ";

?>