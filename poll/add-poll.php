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

    $newPoll = new addPoll($uid);
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
        <div class="form-group row">
            <div id="questionName" class="col-xs-5">
                <label class="control-label" for="questionName">Question</label>
                <input type="text" class="form-control" id="q-name"
                    aria-describedby="questionHelp"/>
                <small id="questionHelp" class="form-text text-muted">i.e. What is your favourite colour?</small>
            </div>
        </div><!--end form-group for Question name-->
        <div class="form-group row" id="options-area">
            <div class="col-xs-5">
                <label for="controls" class="control-label">Options</label>
                <div class="controls">
                    <div class="entry input-group">
                        <input type="text" class="form-control" name="option[]"/>
                        <span class="input-group-btn">
                            <button class="btn btn-success btn-add" type="button">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </span>
                    </div><!--end entry input-group-->
                </div>
            </div><!--end controls-->
        </div><!--end form-group for Options-->

        <div class="form-group row">
            <div class="col-xs-5">
                <label for="user-group" class="control-label">Belongs to Group:</label>
                <div id="user-group">
                    <?php 
                    $groups  = $newPoll->get_users_groups();
                    foreach($groups as $group){
                    echo '
                    <div class="radio">
                        <label>
                            <input type="radio" value="'.$group[0].'" name="group[]" checked>'.$group[1].'
                        </label>
                    </div>';
                    }
                    ?>
                </div>
            </div><!--end user-group-->
        </div><!--end form-group for Group-->

        <div class="form-group row">
            <div id="survey-tag" class="col-xs-5">
                <label for="survey-tag" class="control-label">Tag(s)</label>
                <input type="text" class="form-control" id="s-tag"
                    aria-describedby="tagHelp" placeholder="food, friends, fun"/>
                <small id="tagHelp" class="form-text text-muted">Seperate each tag by a comma</small>
            </div>
        </div><!--end form-group for Tags-->

        <!--Sumbit button start-->
        <div class="form-group row">
            <div class="col-xs-5">
                <button id="submit" type="submit" class="btn btn-default">Add Question</button>
            </div>
        </div>
    </form>

</body>
</html>