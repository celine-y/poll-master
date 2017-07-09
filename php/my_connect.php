<?php
// Function to obtain mysqli connection.
function get_mysqli_conn(){

	$dbhost = "mansci-db.uwaterloo.ca";
	$dbuser = "k3kittan";
	$dbpass = "";
	$dbname = "k3kittan_proj";

   //Connect to MySQL Server
	$conn = mysql_connect($dbhost, $dbuser, $dbpass);

   //Select Database
	mysql_select_db($dbname) or die(mysql_error());

	if(! $conn ) {
		die('Could not connect: ' . mysql_error());
	}

}
?>
