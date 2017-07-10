<?php

 $dbhost = "mansci-db.uwaterloo.ca";
 $dbuser = "k3kittan";
 $dbpass = "";

$uname = $_POST['uname']; 
$upass = $_POST['upass'];

//USE EXIST TO CHECK IF USERNAME EXIST IN TABLE ALREADY
mysql_select_db('k3kittan_proj');
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