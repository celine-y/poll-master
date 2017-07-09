<?php
session_start();

$voteid = (int) $_POST['vote'];
$userid = (int) $_SESSION['userId'];

include('../php/my_connect.php');

$con = get_mysqli_conn();

$sqlStr = "INSERT INTO uservote (userid, oid) VALUES (?,?)";

$query = $con->prepare($sqlStr);
$query->bind_param("ii", $userid, $voteid);

$query->execute();

if ($query->errno){
    echo 'Error inserting your vote. Userid='.$userid.' Oid='.$voteid;
}
else{
    header('Location: poll-display.php');
}

$query->close();
$con->close();

?>