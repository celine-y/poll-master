
<?php

include('./my_connect.php');
get_mysqli_conn();

$gid = $_GET['gid'];

$gid = mysql_real_escape_string($gid);

//get group name
$query = "Select g.name from groups g where g.gid=$gid";

$qry_result = mysql_query($query) or die(mysql_error());

$row= mysql_fetch_array($qry_result);

//send back data to ajax call
echo json_encode($row[name]);

?>