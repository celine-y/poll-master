<html>
<header>
</header>

<body>
    <div id="content">
<?php
include('../php/my_connect.php');
//get if user has voted previously
$userid = 1;
$sid = 1;

$con = get_mysqli_conn();

//statement to select the row of uservote based on survey
$strStmt = "SELECT *
    FROM uservote u
    INNER JOIN options o ON o.oid = u.oid
    WHERE u.userid=".$userid."
    AND o.sid=".$sid;

$query = mysqli_query($con, $strStmt);
$uservote = (mysqli_num_rows($query) > 0) ? true: false;

//print out the title
$strStmt = 'SELECT s.question
    FROM survey s
    WHERE s.sid='.$sid;

$query = mysqli_query($con, $strStmt);
if (!$query){
    die('Could not query='.$strStmt);
}
$question = $query->fetch_row()[0];
//print out question title
echo '<div id="title">
        <h1>'.$question.'</h1>
    </div>';


//user has voted before
if ($uservote){
    echo 'User voted before';
    $strStmt = 'SELECT uv.oid, COUNT(*)
    FROM uservote uv
    WHERE uv.oid IN (SELECT opt.oid
                    FROM options opt
                    WHERE opt.sid='.$sid.')
    GROUP BY uv.oid
    ';

}
//user has not voted before
else{
    $strStmt = 'SELECT opt.options, opt.oid
        FROM options opt
        WHERE opt.sid='.$sid;
        
    $query = mysqli_query($con, $strStmt);
    if (!$query){
        die('Could not query='.$strStmt);
    }
    
    echo '<form>';
    while ($row = $query->fetch_row()){
        echo '<input type="radio" name="vote" value="'.$row[1].'">'
            .$row[0].'</input>';
        echo '<br>';
    }
    echo '<input type="submit" name="submit" value="Submit"></input>';
    echo '</form>';
}

$con->close();
$query->close();

?>
    </div><!--end div content-->
</body>