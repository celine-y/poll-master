<?php
include('../php/my_connect.php');
//class used in poll-display.php 
//used to check if user has voted, and what info to display
class poll{
    private $con;
    private $userid;
    private $surveyid;

    function __construct($uid, $sid){
        $this->userid = $uid;
        $this->surveyid = $sid;
        $this->con = cy_conn();
    }

    //boolean for hasUserVoted
    function hasUserVoted(){
        
        //statement to select the row of uservote based on survey
        $strStmt = "SELECT *
            FROM uservote u
            INNER JOIN options o ON o.oid = u.oid
            WHERE u.userid=".$this->userid."
            AND o.sid=".$this->surveyid;

        $query = mysqli_query($this->con, $strStmt);
        $uservote = (mysqli_num_rows($query) > 0) ? true: false;

        return $uservote;
    }

    //get user's username
    //used for redirecting to homepage
    function getUserName(){
        //select username for user
        $strStmt = "SELECT u.username
        FROM user u
        WHERE u.userid=".$this->userid;

        $query = mysqli_query($this->con, $strStmt);
        if(!$query){
            die('Could not query='.$strStmt);
        }
        $username = $query->fetch_row()[0];

        return $username;
    }

    function getTitle(){
        //print out the survey's title
        $strStmt = 'SELECT s.question
            FROM survey s
            WHERE s.sid='.$this->surveyid;

        $query = mysqli_query($this->con, $strStmt);
        if (!$query){
            die('Could not query='.$strStmt);
        }
        $question = $query->fetch_row()[0];

        return $question;
    }

    //return html string with the results
    function poll_html_results(){
        $htmlStr = "";
        
        foreach($this->get_poll_results() as $result){
            // $htmlStr .= '<div class="option-title">'.$result['opt_name'].'</div>
            //     <div class="option-nunm">'.(string)$result['opt_num'].'</div></br>';
            $htmlStr .= $result['opt_name'].'<span class="pull-right">'.$result['opt_num'].'</span>
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="'.$result['opt_num'].'"
                aria-valuemin="0" aria-valuemax="100" style="width:'.$result['opt_num'].'%"></div>
            </div>
             ';
        }
        return $htmlStr;
    }

    //get the poll option and percent
    function get_poll_results(){
        
        //select each option's name, count and userid for the survey
        $strStmt = 'SELECT opt.options, COUNT(*), uv.userid
        FROM uservote uv
        INNER JOIN options opt ON opt.oid = uv.oid
        WHERE opt.sid ='.$this->surveyid.'
        GROUP BY uv.oid
        ORDER BY uv.oid
        ';

        $query=mysqli_query($this->con, $strStmt);
        if (!$query){
            die('Could not query='.$strStmt);
        }

        //format $query into array(array(question name, percent))
        $voteInfo = array(array());
        $q = 0;
        $totalVote = 0;
        while($option = $query->fetch_row()){
            $voteInfo[$q]['opt_name']=trim($option[0]);
            $voteInfo[$q]['opt_num']=(double)$option[1];
            $totalVote += $option[1];
            $q++;
        }

        //format vote number to percentage
        foreach($voteInfo as &$question){
            $question['opt_num'] = round(($question['opt_num']/$totalVote)*100, 2);
        }

        //select all the options that have not been selected
        $strStmt = "SELECT opt.options
            FROM options opt
            LEFT JOIN uservote uv ON uv.oid = opt.oid
            WHERE opt.sid=".$this->surveyid."
            AND uv.userid IS NULL             
            ";

        $query = mysqli_query($this->con, $strStmt);
        if(!$query){
            die('Could not query='.$strStmt);
        }
        while ($option = $query->fetch_row()){
            $voteInfo[$q]['opt_name'] = $option[0];
            $voteInfo[$q]['opt_num'] = 0;
            $q++;
        }

        return $voteInfo;
    }

    //get all options
    function get_options(){
        //select all options (name and id) for the survey
        $strStmt = 'SELECT opt.options, opt.oid
            FROM options opt
            WHERE opt.sid='.$this->surveyid;

        $query = mysqli_query($this->con, $strStmt);
        if (!$query){
            die('Could not query='.$strStmt);
        }
        $result = array();

        while($row = $query->fetch_row()){
            array_push($result, $row);
        }
        return $result;
    }

}
?>