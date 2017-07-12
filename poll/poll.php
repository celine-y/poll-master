<?php
include('../php/my_connect.php');
class poll{
    private $con;
    private $userid;
    private $surveyid;

    function __construct($uid, $sid){
        $this->userid = $uid;
        $this->surveyid = $sid;
        $this->con = cy_conn();
    }

    function hasUserVoted(){
        
        // $this->$con = cy_conn();
        //statement to select the row of uservote based on survey
        $strStmt = "SELECT *
            FROM uservote u
            INNER JOIN options o ON o.oid = u.oid
            WHERE u.userid=".$this->userid."
            AND o.sid=".$this->surveyid;

        $query = mysqli_query($this->con, $strStmt);
        $uservote = (mysqli_num_rows($query) > 0) ? true: false;

        // $this->$con->close();
        // $query->close();
        return $uservote;
    }

    function getTitle(){
        // $this->$con = cy_conn();
        //print out the title
        $strStmt = 'SELECT s.question
            FROM survey s
            WHERE s.sid='.$this->surveyid;

        $query = mysqli_query($this->con, $strStmt);
        if (!$query){
            die('Could not query='.$strStmt);
        }
        $question = $query->fetch_row()[0];

        // $this->$con->close();
        // $query->close();
        return $question;
    }

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

    function get_poll_results(){
        
        // $this->$con = get_mysqli_conn();
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

        foreach($voteInfo as &$question){
            $question['opt_num'] = round(($question['opt_num']/$totalVote)*100, 2);
        }

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

        // $this->$con->close();
        // $query->close();

        return $voteInfo;
    }

    function get_options(){
        
        // $this->$con = get_mysqli_conn();
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

        
        // $this->$con->close();
        // $query->close();
        return $result;
    }

}
?>