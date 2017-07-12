<html>
<head>
    <?php
    include('add-poll-function.php');
    session_start();

    $uid = $_SESSION['userId'];
    //TESTING
    // if ($uid == NULL){
    //     $uid = 2;
    //     $_SESSION['userId'] = $uid;
    // }

    $newPoll = new addPoll($uid);
    $username = $newPoll->getUserName();

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

    <!--used for going back to home page-->
    <script type="text/javascript">
        var userid ="<?php echo $uid; ?>";
        var username = "<?php echo $username; ?>"
    </script>
    <script src="../js/navbar.js"></script>

</head>
<body>
    <?php include('../navbar.html'); ?>
    <div class="container">
        <div class="row">
            <section class="content">
                <div class="col-md-offset-3 col col-md-6">
                    <h1 id="title">Add a survey</h1>
                    <div id="response"></div>
                        <div id="add-panel" class="panel panel-default">
                            <div class="panel-body">
                                <form role="form" id="add-poll" method="post">
                                    <div class="form-group row">
                                        <div id="questionName" class="col col-md-12">
                                            <h2 class="control-label" for="questionName">Question</h2>
                                            <input type="text" class="form-control" id="q-name"
                                                aria-describedby="questionHelp"/>
                                            <h5 id="questionHelp" class="form-text text-muted">i.e. What is your favourite colour?</h5>
                                        </div>
                                    </div><!--end form-group for Question name-->
                                    <div class="form-group row" id="options-area">
                                        <div class="col col-md-12">
                                            <h2 for="controls" class="control-label">Options</h2>
                                            <div class="controls">
                                                <div class="entry input-group">
                                                    <input type="text" class="form-control" name="option[]"/>
                                                    <span class="input-group-btn">
                                                        <button class="btn btn-remove btn-danger" type="button">
                                                            <span class="glyphicon glyphicon-minus"></span>
                                                        </button>
                                                    </span>
                                                </div><!--end entry input-group-->
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
                                        <div class="col col-md-12">
                                            <h2 for="user-group" class="control-label">Belongs to Group</h2>
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
                                        <div id="survey-tag" class="col col-md-12">
                                            <h2 for="survey-tag" class="control-label">Tag(s)</h2>
                                            <input type="text" class="form-control" id="s-tag"
                                                aria-describedby="tagHelp" placeholder="food, friends, fun"/>
                                            <h5 id="tagHelp" class="form-text text-muted">Seperate each tag by a comma</h5>
                                        </div>
                                    </div><!--end form-group for Tags-->

                                    <div class="form-group row">
                                        <div id="survey-color" class="col col-md-12">
                                            <h2 for="survey-color" class="control-label">Urgency</h2>
                                            <?php
                                            $status = $newPoll->get_colour();
                                            foreach($status as $colour){
                                                if ($colour[0] != NULL){
                                                    if ($colour[1] == 1){
                                                        $colour[0] .= " active";
                                                    }
                                                    echo '<button type="button" class="btn '.$colour[0].'" value="'.$colour[1].'">'.$colour[2].'</button>';
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div><!--end form-group for Colors-->

                                    <!--Sumbit button start-->
                                    <div class="form-group row">
                                        <div class="col col-md-12">
                                            <button id="submit" type="submit" class="btn btn-default">Add Question</button>
                                        </div>
                                    </div>
                                </form>
                            </div><!--end panel-body-->
                    </div><!--end panel-default-->
                </div><!--end col-md-7-->
            </section>
        </div><!--end row-->
    </div><!--end container-->
</body>
</html>