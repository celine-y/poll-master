<?php
error_reporting(E_ALL ^ E_NOTICE);

// Function to obtain mysqli connection.
<<<<<<< HEAD
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

=======
function get_mysqli_conn()
{
    $dbhost = 'mansci-db.uwaterloo.ca';
    $dbuser = 'clcyau';
    $dbpassword = '';
    $dbname = 'clcyau_pollmaster';
    $mysqli = new mysqli($dbhost, $dbuser, $dbpassword, $dbname);
    if ($mysqli->connect_errno) 
    {
        echo 'Failed to connect to MySQL: (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error;
    }
    return $mysqli;
>>>>>>> 82f0e0c986de2b98e22802bf60bf5a71baef38f0
}
?>
