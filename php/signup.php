<?php

 $dbhost = "mansci-db.uwaterloo.ca";
 $dbuser = "clcyau";
 $dbpass = "p0llmaster123";
 $conn = mysql_connect($dbhost, $dbuser, $dbpass);

$uname = $_POST['uname']; 
$upass = $_POST['upass'];

//CHECK IF USERNAME EXIST IN TABLE ALREADY
mysql_select_db('clcyau_pollmaster');
$query="Select username from user where username='$uname'";

$qry_result = mysql_query($query) or die(mysql_error());

if (mysql_num_rows($qry_result)==0){
	$sql = "INSERT INTO user (username, pw) VALUES ('$uname', '$upass')";

	$retval = mysql_query( $sql, $conn);

	if(! $retval ) {
		die('Could not enter data: ' . mysql_error().$conn);
	}else{
		echo json_encode("sucess");
	}
}else{
	echo json_encode("error");
}

mysql_close($conn);

?>