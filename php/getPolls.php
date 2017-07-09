
<?php

include('./my_connect.php');
get_mysqli_conn();

$uid = $_GET['userid'];
$uid = mysql_real_escape_string($uid);


$query = "Select s.sid, s.question, c.descrip as status, coalesce(f.active,'F')as fave"
." From usergroup ug"
." Left Join groupsurvey gs on gs.gid=ug.gid"
." Join survey s on s.sid=gs.sid"
." Left Join favourite f on f.userid=$uid and f.sid=s.sid"
." Join color c on c.cid=s.cid"
." Where ug.userid=$uid";

$qry_result = mysql_query($query) or die(mysql_error());

$result = array();
//sid, sq, status, favourite, tags, group memebers,username
while ($row = mysql_fetch_array($qry_result)) {
	$data = array (
			"sid" => $row[sid],
			"sq" => $row[question],
			"status" => $row[status],
			"fave" => $row[fave],
	);

	array_push($result,$data);
}

echo json_encode($result);

?>
