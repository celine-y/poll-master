<?php
// Enable error logging: 
error_reporting(E_ALL ^ E_NOTICE);
// mysqli connection via user-defined function
include ('./my_connect.php');
$mysqli = get_mysqli_conn();

// $sid = $_POST['sid'];
// $uid = $_POST['userid'];
// $action = $_POST['action'];

// if ($action=='insert'){
// 	$sql = "Insert into favourite"
// 	."Values (?,?)";	
// }else{
// 	$sql = "Delete from favourite"
// 	."where favourite.userid=? and favourite.sid=?";	
// }

$sql = "Insert into favourite"
."Values (345,234)";	

$stmt = $mysqli->prepare($sql);
$stmt->execute();
//$stmt->bind_param('ii', $userid, $sid); 

$stmt->close(); 
$mysqli->close();
?>