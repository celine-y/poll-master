<?php

$dbhost = "mansci-db.uwaterloo.ca";
$dbuser = "clcyau";
$dbpass = "p0llmaster123";
$conn = mysql_connect($dbhost, $dbuser, $dbpass);

$gname = $_POST['gname']; 
$gmem = $_POST['gmem'];
$admin = $_POST['admin'];

$memarr=explode(',', $gmem);

mysql_select_db('clcyau_pollmaster');
$query="Select g.gid FROM groups g where g.Adminid=$admin and g.name='$gname'";

$qry_result = mysql_query($query) or die(mysql_error());

if (mysql_num_rows($qry_result)==0){
	//add groups
	$sql = "INSERT INTO groups (Adminid, name) VALUES ($admin, '$gname')";

	$retval = mysql_query( $sql, $conn);

	if(! $retval ) {
		die('Could not enter data: ' . mysql_error().$conn);
	}else{
		$qry_result = mysql_query($query) or die(mysql_error());
		$row= mysql_fetch_array($qry_result);
		$gid=$row[gid];

		//add to usergroup
		$sqlmem = array();
		foreach($memarr as $uid){
			$sqlmem[]='('.mysql_real_escape_string($gid).', '.$uid.')';
		}
		$sqlUserGroup="INSERT INTO usergroup (gid, userid) VALUES".implode(',',$sqlmem);

		$retval = mysql_query( $sqlUserGroup, $conn);
		if(! $retval ) {
			die('Could not enter data: ' . mysql_error().$conn);
		}else{
			echo json_encode("success");
		}
	}

}else{
	echo json_encode("error");
}

mysql_close($conn);

?>