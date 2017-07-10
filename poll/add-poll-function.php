<?php
include('../php/my_connect.php');
session_start();

$con = cy_conn();

$uid = $_SESSION['userId'];
if ($uid == NULL){
    $uid = 2;
    $_SESSION['userId'] = $uid;
}

function create_poll($question, $options){

}

function get_users_groups(){
    $strStmt = "SELECT g.gid, g.name
    FROM groups g
    WHERE g.gid IN (
        SELECT userg.gid
        FROM usergroup userg
        WHERE userg.userid = '.$uid'
    )";

    $query = mysqli_query($con, $strStmt);

    if (!$query){
        die('Could not query='.$strStmt);
    }
    
    $groups = array();

    while($row = $query->fetch_row()){
        array_push($groups, $row);
    }
    
    return($groups);
}

?>