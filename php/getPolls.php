
<?php

include('./my_connect.php');
get_mysqli_conn();

$uid = $_GET['userid'];

$uid = mysql_real_escape_string($uid);

//id, sq, status, favourite, tags, group memebers
$query =
"Select s.sid, s.question, c.descrip as status, coalesce(f.active,'F')as fave, COALESCE(tags.hash,'') as tags, gmem.mem
From usergroup ug
Left Join groupsurvey gs on gs.gid=ug.gid
Join survey s on s.sid=gs.sid
Left Join favourite f on f.userid=$uid and f.sid=s.sid
Join color c on c.cid=s.cid
/*group members*/
Join (	Select ug.gid,GROUP_CONCAT(u.username)as mem
From usergroup ug
Join user u on u.userid=ug.userid
Group by ug.gid
)gmem on gmem.gid=ug.gid
/*tags*/
Left Join (	Select st.sid,GROUP_CONCAT(t.tname SEPARATOR ' ')as hash
From surtags st
Join tags t on st.tid=t.tid
Group by st.sid
)tags on tags.sid=s.sid
Where ug.userid=$uid
Order by s.sid DESC";

$qry_result = mysql_query($query) or die(mysql_error());

$result = array();
//sid, sq, status, favourite, tags, group memebers,username
while ($row = mysql_fetch_array($qry_result)) {
	$data = array (
		"sid" => $row[sid],
		"sq" => $row[question],
		"status" => $row[status],
		"fave" => $row[fave],
		"tags" => $row[tags],
		"gmem" => $row[mem]);

	array_push($result,$data);
}

echo json_encode($result);

?>
