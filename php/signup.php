<?php

$dbhost = 'mansci-db.uwaterloo.ca';
$dbuser = 'k3kittan';
$dbpass = '023193190_Tata';
$conn = mysql_connect($dbhost, $dbuser, $dbpass);

$uname = $_POST['uname']; 
$upass = $_POST['upass'];

//USE EXIST TO CHECK IF USERNAME EXIST IN TABLE ALREADY

$sql = "INSERT INTO user (username, pw) VALUES ('$uname', '$upass')";

mysql_select_db('k3kittan_proj');
$retval = mysql_query( $sql, $conn );

if(! $retval ) {
	die('Could not enter data: ' . mysql_error());
}else{
	echo json_encode("sucess");
}

mysql_close($conn);

?>