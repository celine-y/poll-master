<?php
// Enable error logging: 
error_reporting(E_ALL ^ E_NOTICE);
// mysqli connection via user-defined function
include ('./my_connect.php');
$mysqli = get_mysqli_conn();
?>

<?php
$sql = "Select username"
	  ."from username"
	  ."where userid=1";

$stmt = $mysqli->prepare($sql);

$uid = $_GET['userid'];


//GET ERROR seems to occur here..
//$stmt->bind_param('i', $uid); 

//$stmt->execute();

//$stmt->bind_result($userName);

//$data =  array('msg' => 'true');
//echo json_encode($data);

//sid, sq, status, favourite, group memebers
$data = array (
	array("sid" => 1,
	"sq" => "what to eat?",
	"status" => "urgent"),
	array("sid" => 2,
	"sq" => "what time do u sleep at?",
	"status" => "moderate")
	);

echo json_encode($data);

//$stmt->close();
$mysqli->close();
?>
