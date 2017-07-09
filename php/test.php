
<?php
// Enable error logging: 
error_reporting(E_ALL ^ E_NOTICE);
// mysqli connection via user-defined function

include('./my_connect.php');
$mysqli = get_mysqli_conn();

// SQL statement
$sql = "SELECT a.aid, a.aname, a.cruisingrange "
. "FROM aircraft a ";
//. "WHERE a.aid = ?";

// Prepared statement, stage 1: prepare
$stmt = $mysqli->prepare($sql);

// Prepared statement, stage 2: bind and execute 
$aid = $_GET['aid']; 
// "i" for integer, "d" for double, "s" for string, "b" for blob 
$stmt->bind_param('i', $aid); 
$stmt->execute();

// Bind result variables 
$stmt->bind_result($a_id, $a_name, $a_range); 

$data = array();
/* fetch values */ 
while ($stmt->fetch()){
	$row = array(
    "sid" => $a_id,
    "sq" => $a_name,
    "status" => $a_range
    );

	array_push($data,$row);
}

echo json_encode($data);

$stmt->close(); 
$mysqli->close();
?>