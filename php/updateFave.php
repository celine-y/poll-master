<?php

 $dbhost = "mansci-db.uwaterloo.ca";
 $dbuser = "k3kittan";
 $dbpass = "p0llmaster123";
 $conn = mysql_connect($dbhost, $dbuser, $dbpass);


if(! $conn ) {
	die('Could not connect: ' . mysql_error());
}

$uid = $_POST['userid'];
$sid = $_POST['sid'];
$action = $_POST['action'];


if ($action=="insert"){
	$sql="INSERT INTO favourite VALUES ($uid, $sid)";
}else if ($action=="delete"){
	$sql="DELETE FROM favourite WHERE sid=$sid";
}

mysql_select_db('k3kittan_proj');
$retval = mysql_query( $sql, $conn );

if(! $retval ) {
	die('Could not update data: ' . mysql_error());
}

echo json_encode("success");

mysql_close($conn);
?>