
<?php

include('./my_connect.php');
get_mysqli_conn();

//get username, and userid
$query ="SELECT u.username, u.userid FROM user u order by u.username";

$qry_result = mysql_query($query) or die(mysql_error());

$result = array();

while ($row = mysql_fetch_array($qry_result)) {
	$data = array (
		"uid" => $row[userid],
		"username" => $row[username]);
	array_push($result,$data);
}

//send back data to ajax call
echo json_encode($result);

?>
