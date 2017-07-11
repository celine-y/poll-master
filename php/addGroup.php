<?php

 $dbhost = "mansci-db.uwaterloo.ca";
 $dbuser = "k3kittan";
 $dbpass = "p0llmaster123";
 $conn = mysql_connect($dbhost, $dbuser, $dbpass);

$gname = $_POST['gname']; 
$mem = $_POST['members'];
$admin = $_POST['uid'];

$gname = mysql_real_escape_string($gname);

//CHECK IF GROUPNAME EXIST ALREADY
mysql_select_db('k3kittan_proj');
$query="SELECT gid FROM groups where Adminid=$admin and name=$gname";

$qry_result = mysql_query($query) or die(mysql_error());

if (mysql_num_rows($qry_result)==0){
	//add groups
	$sql = "INSERT INTO groups (Adminid, name) VALUES ($admin, $gname)";

	$retval = mysql_query( $sql, $conn);

	if(! $retval ) {
		die('Could not enter data: ' . mysql_error().$conn);
	}
	echo json_encode("success". $mem);
	//add to usergroup

}else{
	echo json_encode("error");
}

mysql_close($conn);

?>