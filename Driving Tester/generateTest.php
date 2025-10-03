<?php
require_once('LogicHandler.php');
session_start();
$logichandler = new LogicHandler();
$logichandler->LoginGuard();

if(isset($_POST["TypeSubmission"])) {
    $logichandler -> prepareTest($_POST["ExamType"]);
    echo "<script> window.location.replace('testPage.php'); </script>";
}
