<html>
<header>
    <?php
    include('add-poll-function.php');
    session_start();

    $uid = $_SESSION['userId'];
    if ($uid == NULL){
        $uid = 2;
        $_SESSION['userId'] = $uid;
    }
    ?>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">

    <link rel="stylesheet" href="css/poll.css">

    <!-- jQuery library -->
    <script src="../js/jquery-2.2.4.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="../js/bootstrap.min.js"></script>

    <!--submitting form-->
    <script src="js/poll-adding.js"></script>
</header>
<body>
    <h1 id="title">Add a survey
    </h1>
    <form role="form" id="add-poll" method="post">
        <div class="form-group">
            <label class="control-label" for="questionName">Question</label>
            <input type="text" class="form-control" id="questionName"
                aria-describedby="questionHelp"/>
            <small id="questionHelp" class="form-text text-muted">i.e. What is your favourite colour?</small>
        </div><!--end form-group-->
        <div class="form-group" id="options-area">
            <label for="controls" class="control-label">Options</label>
            <div class="controls">
                <div class="entry input-group col-xs-5">
                    <input type="text" class="form-control" name="option[]"/>
                    <span class="input-group-btn">
                        <button class="btn btn-success btn-add" type="button">
                            <span class="glyphicon glyphicon-plus"></span>
                        </button>
                    </span>
                </div><!--end entry input-group-->
            </div><!--end controls-->
        </div><!--end form-group-->

        <div class="form-group">
            <?php 
            // $groups  = get_users_groups();
            // var_dump($groups);
            foreach($groups as $group){
            echo '
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="'.$group[0].'">'.$group[1].'
                </label>
            </div>';
            }
            ?>
        </div>

        <!--Sumbit button start-->
        <div class="form-group">
            <div class="col-xs-5 col-xs-offset-3">
                <button type="submit" class="btn btn-default">Add Question</button>
            </div>
        </div>
    </form>

</body>
</html>