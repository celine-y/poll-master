<?php

 $dbhost = "mansci-db.uwaterloo.ca";
 $dbuser = "clcyau";
 $dbpass = "p0llmaster123";
 $conn = mysql_connect($dbhost, $dbuser, $dbpass);

$gname = $_POST['gname']; 
$gid = $_POST['gid'];

$gname=mysql_real_escape_string($gname);

mysql_select_db('clcyau_pollmaster');

//get group name
$query="Select g.name from groups g where g.name='$gname'";

$qry_result = mysql_query($query) or die(mysql_error());

//if no group name exist
if (mysql_num_rows($qry_result)==0){
	$sql = "UPDATE groups SET name='$gname' where gid=$gid";

	$retval = mysql_query( $sql, $conn);

	if(! $retval ) {
		die('Could not enter data: ' . mysql_error().$conn);
	}else{
		echo json_encode("success");
	}
}else{
	//don't allow user to update group name if it existed already
	echo json_encode("error");
}

mysql_close($conn);

?>