
<?php

include('./my_connect.php');
get_mysqli_conn();

$uname= $_GET['uname'];
$upass= $_GET['upass'];

$uname = mysql_real_escape_string($uname);
$upass = mysql_real_escape_string($upass);


$query = "Select u.pw from user u where BINARY u.username='$uname'";

$qry_result = mysql_query($query) or die(mysql_error());

//sid, sq, status, favourite, tags, group memebers,username
while ($row = mysql_fetch_array($qry_result)) {
	$data = $row[pw];
}

if ($data!=$upass){
	echo json_encode('error');
}else{
	echo json_encode('sucess');
}

?>
