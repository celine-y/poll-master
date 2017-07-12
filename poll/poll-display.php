<html>
<head>
    <?php
    include('poll.php');
    session_start();

    $uid = $_SESSION['userId'];
    $sid = $_SESSION['sid'];
    // //TESTING
    // if ($uid == NULL){
    //     $uid = 1;
    //     $_SESSION['userId'] = $uid;
    // }
    // if ($sid == NULL){
    //     $sid = 31;
    //     $_SESSION['sid'] = $sid;
    // }
    $poll = new poll($uid, $sid);
    $username = $poll->getUserName();
    ?>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="css/poll.css">

    <!-- jQuery library -->
    <script src="../js/jquery-2.2.4.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <!--used for going back to home page-->
    <script type="text/javascript">
        var userid ="<?php echo $uid; ?>";
        var username = "<?php echo $username; ?>"
    </script>
    <script src="../js/navbar.js"></script>

</head>

<body>
    <?php
    include('../navbar.html');
    ?>
    <div class="container">
        <div class="row">
            <section class="content">
                <div class="col-md-offset-3 col-md-6">
                    <h1 id="title"><?php echo $poll->getTitle();?></h3>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div id="poll-content">
                                <?php
                                if (!$poll->hasUserVoted()){ //user has not voted
                                    $pollOpt = $poll->get_options(); ?>
                                    <div id="poll-form" class="poll-area">
                                        <form action="poll-submit.php" method="post">
                                            <div class="form-group">
                                            <?php
                                            foreach($pollOpt as $row){
                                                echo '
                                                <div class="radio">
                                                    <label><input type="radio" name="vote" value="'.$row[1].'">'
                                                    .$row[0].'</label>
                                                </div>';
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
                        </div><!--end panel-body-->
                    </div><!--end panel panel-default-->
                </div><!--end col-md-7-->
            </section>
        </div><!--end row-->
    </div><!--end container-->
</body>
