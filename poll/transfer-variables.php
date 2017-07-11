<?php
if ($_POST['userid'] != NULL){
    $_SESSION['userId'] = $_POST['userId'];
}
if ($_POST['sid'] != NULL){
    $_SESSION['sid'] = $_POST['sid'];
}
echo true;
?>