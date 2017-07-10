<?php
include('../php/my_connect.php');
// session_start();

// $con = cy_conn();

// $uid = $_SESSION['userId'];
// echo 'UID'.$uid;
// if ($uid == NULL){
//     $uid = 2;
//     $_SESSION['userId'] = $uid;
// }

class addPoll{
    private $con;
    private $userid;

    function __construct($uid){
        $this->userid = $uid;
        $this->con = cy_conn();
    }

    //$questionInfo = array(question, array(opt1, opt2, ...))
    function create_poll($questionInfo){
        
    }

    function get_users_groups(){

        $strStmt = "SELECT g.gid, g.name
        FROM groups g
        WHERE g.gid IN (
            SELECT userg.gid
            FROM usergroup userg
            WHERE userg.userid=".$this->userid."
        )";

        $query = mysqli_query($this->con, $strStmt);

        if (!$query){
            die('Could not query='.$strStmt);
        }
        
        $groups = array();

        while($row = $query->fetch_row()){
            array_push($groups, $row);
        }
        
        return($groups);
    }
}

?>