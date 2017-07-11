<?php
include('../php/my_connect.php');

class addPoll{
    private $con;
    private $userid;

    function __construct($uid){
        $this->userid = $uid;
        $this->con = cy_conn();
    }

    function get_colour(){
        $strStmt = "SELECT class, cid, descrip
            FROM color
            ORDER BY cid";

        $query = mysqli_query($this->con, $strStmt);

        if (!$query){
            die('Could not query='.$strStmt);
        }

        $colours = array(array());
        while($colourInfo = $query->fetch_row()){
            if ($colourInfo != NULL){
                array_push($colours, $colourInfo);
            }
        }
        
        // var_dump($colours);
        return $colours;
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