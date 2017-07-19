<?php

 $dbhost = "mansci-db.uwaterloo.ca";
 $dbuser = "clcyau";
 $dbpass = "p0llmaster123";
 $conn = mysql_connect($dbhost, $dbuser, $dbpass);


if(! $conn ) {
	die('Could not connect: ' . mysql_error());
}

$uid = $_POST['userid'];
$sid = $_POST['sid'];
$action = $_POST['action'];

//if its not favourited yet, then insert
if ($action=="insert"){
	$sql="INSERT INTO favourite VALUES ($uid, $sid)";
//if its favourited already, then delete
}else if ($action=="delete"){
	$sql="DELETE FROM favourite WHERE sid=$sid and userid=$uid";
}

mysql_select_db('clcyau_pollmaster');
$retval = mysql_query( $sql, $conn );

if(! $retval ) {
	die('Could not update data: ' . mysql_error());
}

//send data back through ajax call
echo json_encode("success");

mysql_close($conn);
?>