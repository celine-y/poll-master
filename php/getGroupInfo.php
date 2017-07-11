
<?php

include('./my_connect.php');
get_mysqli_conn();

$uid = $_GET['uid'];
$gid = $_GET['gid'];

$uid = mysql_real_escape_string($uid);
$gid = mysql_real_escape_string($gid);

//gid, gname, admin, gmem
$query = "
Select u.userid, u.username, Case when gid is not null then 'T'
else 'F' end as mem
From user u
Left join usergroup ug on ug.gid=$gid and ug.userid=u.userid
Order by u.username";

$qry_result = mysql_query($query) or die(mysql_error());

$result = array();
while ($row = mysql_fetch_array($qry_result)) {
	$data = array (
		"uid" => $row[userid],
		"uname" => $row[username],
		"mem" => $row[mem],
		);
	array_push($result,$data);
}

echo json_encode($result);

?>