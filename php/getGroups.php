
<?php

include('./my_connect.php');
get_mysqli_conn();

$uid = $_GET['userid'];


$uid = mysql_real_escape_string($uid);

//gname, mem
$query = "
Select 	g.gid, g.name,
Case When g.adminid=$uid Then 'T' Else 'F' End as admin,
gmem.mem
From usergroup ugg
Join groups g on g.gid=ugg.gid
Join (	Select ug.gid,GROUP_CONCAT(u.username SEPARATOR ', ')as mem
From usergroup ug
Join user u on u.userid=ug.userid
Group by ug.gid
)gmem on gmem.gid=ugg.gid
Where ugg.userid=$uid";

$qry_result = mysql_query($query) or die(mysql_error());

$result = array();
while ($row = mysql_fetch_array($qry_result)) {
	$data = array (
		"gid" => $row[gid],
		"gname" => $row[name],
		"admin" => $row[admin],
		"gmem" => $row[mem],
		);
	array_push($result,$data);
}

echo json_encode($result);

?>