<?php
include('../php/my_connect.php');

//class used in add-poll.php
//deals with all the functions to process/retrieve data
class addPoll{
    private $con;
    private $userid;

    function __construct($uid){
        $this->userid = $uid;
        $this->con = cy_conn();
    }

    //get user's username
    //used for going back to the home page
    function getUserName(){
        //select username based on userid
        $strStmt = "SELECT u.username
        FROM user u
        WHERE u.userid=".$this->userid;

        $query = mysqli_query($this->con, $strStmt);
        //db error check
        if(!$query){
            die('Could not query='.$strStmt);
        }
        $username = $query->fetch_row()[0];

        return $username;
    }

    //get different colours (includes class, id, and description)
    function get_colour(){
        //select all the colour's class, cid, and description
        $strStmt = "SELECT class, cid, descrip
            FROM color
            ORDER BY cid";

        $query = mysqli_query($this->con, $strStmt);

        if (!$query){
            die('Could not query='.$strStmt);
        }

        //inserts each colour into array
        $colours = array(array());
        while($colourInfo = $query->fetch_row()){
            if ($colourInfo != NULL){
                array_push($colours, $colourInfo);
            }
        }
        
        return $colours;
    }

    //get the groups the user belongs to
    function get_users_groups(){
        //select the groups' id and name for the user
        $strStmt = "SELECT g.gid, g.name
        FROM groups g
        WHERE g.gid IN (
            SELECT userg.gid
            FROM usergroup userg
            WHERE userg.userid=".$this->userid."
        )";

        $query = mysqli_query($this->con, $strStmt);

        //db error check
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