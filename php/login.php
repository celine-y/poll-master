
<?php

include('./my_connect.php');
get_mysqli_conn();

$uname= $_POST['uname'];
$upass= $_POST['upass'];

$uname = mysql_real_escape_string($uname);
$upass = mysql_real_escape_string($upass);


$query = "Select u.pw, u.userid from user u where BINARY u.username='$uname'";

$qry_result = mysql_query($query) or die(mysql_error());

$uid;
//sid, sq, status, favourite, tags, group memebers,username
while ($row = mysql_fetch_array($qry_result)) {
	$pass = $row[pw];
	$uid = $row[userid];
}

if ($pass!=$upass){
	$status=array("status"=> 'error');
	echo json_encode($status);
}else{
	$status=array("status"=> 'success', "uid"=>$uid);
	echo json_encode($status);
}

?>
