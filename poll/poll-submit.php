<?php
//used to insert user's vote into database
session_start();

$voteid = (int) $_POST['vote'];
$userid = (int) $_SESSION['userId'];

include('../php/my_connect.php');

$con = cy_conn();

$sqlStr = "INSERT INTO uservote (userid, oid) VALUES (?,?)";

$query = $con->prepare($sqlStr);
$query->bind_param("ii", $userid, $voteid);

$query->execute();

//error inserting into database
if ($query->errno){
    echo 'Error inserting your vote. Userid='.$userid.' Oid='.$voteid;
}
else{
    //redirect to poll-display.php
    header('Location: poll-display.php');
}

$query->close();
$con->close();

?>