<?php
session_start();
if ($_POST['userId'] != NULL){
    $_SESSION['userId'] = $_POST['userId'];
}
if ($_POST['sid'] != NULL){
    $_SESSION['sid'] = $_POST['sid'];
}
echo $_SESSION['userId'];
?>