
<?php

include('./my_connect.php');
get_mysqli_conn();

//id, sq, status, favourite, tags, group memebers
$query ="SELECT u.username, u.userid FROM user u order by u.username";

$qry_result = mysql_query($query) or die(mysql_error());

$result = array();
//sid, sq, status, favourite, tags, group memebers,username
while ($row = mysql_fetch_array($qry_result)) {
	$data = array (
		"uid" => $row[userid],
		"username" => $row[username]);
	array_push($result,$data);
}

echo json_encode($result);

?>
