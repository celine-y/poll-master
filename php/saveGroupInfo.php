<?php

$dbhost = "mansci-db.uwaterloo.ca";
$dbuser = "clcyau";
$dbpass = "p0llmaster123";
$conn = mysql_connect($dbhost, $dbuser, $dbpass);

$gname = $_POST['gname']; 
$gmem = $_POST['gmem'];
$admin = $_POST['admin'];
$gid = $_POST['gid'];

$memarr=explode(',', $gmem);

mysql_select_db('clcyau_pollmaster');

$query="DELETE from usergroup where gid=$gid";
$qry_result = mysql_query($query) or die(mysql_error());

$sqlmem = array();
foreach($memarr as $uid){
	$sqlmem[]='('.mysql_real_escape_string($gid).', '.$uid.')';
}

$sql ="INSERT INTO usergroup (gid, userid) VALUES".implode(',',$sqlmem);

$retval = mysql_query( $sql, $conn);

if(! $retval ) {
	die('Could not enter data: ' . mysql_error().$conn);
}else{
	echo json_encode("success");
}

mysql_close($conn);

?>