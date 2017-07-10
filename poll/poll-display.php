<html>
<header>
    <?php
    include('poll.php');
    session_start();

    $uid = $_SESSION['userId'];
    $sid = $_SESSION['sid'];
    if ($uid == NULL){
        $uid = 1;
        $_SESSION['userId'] = $uid;
    }
    if ($sid == NULL){
        $sid = 1;
        $_SESSION['sid'] = $sid;
    }
    $poll = new poll($uid, $sid);
    ?>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="../js/jquery-2.2.4.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="../js/bootstrap.min.js"></script>
</header>

<body>
    <div id="content">
        <div id="poll-content">
            <h3 id="poll-title"><?php echo $poll->getTitle();?>
            </h3>
            <?php
            if (!$poll->hasUserVoted()){ //user has not voted
                $pollOpt = $poll->get_options(); ?>
                <div id="poll-form" class="poll-area">
                    <form action="poll-submit.php" method="post">
                        <div class="form-group">
                        <?php
                        foreach($pollOpt as $row){
                            echo '<input type="radio" name="vote" value="'.$row[1].'">'
                                .$row[0].'</input>';
                            echo '<br>';
                        }
                        //echo '<input type="hidden" name="userid" value="'.$uid.'/>';
                        ?>
                        <input type="submit" name="submit" value="Submit" class="btn btn-primary"/>
                </div><!--end form-group-->
                </form>
                </div><!--end div poll-form-->
                <?php
            } //end hasUserVoted()
            else{
                ?>
                <div id="poll-results" class="poll-area">
                    <h4 class="subtitle">Results</h4>
                <?php
                echo $poll->poll_html_results();
                ?>
                </div><!--end div poll-result-->
            <?php
            } //end user has voted
            ?>
            </form>
        </div><!--end poll-content-->
        
    </div>
</body>
