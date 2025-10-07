<?php
require_once('LogicHandler.php');
session_start();
$logichandler = new LogicHandler();
$logichandler->LoginGuard();


if(isset($_POST["TypeSubmission"])) {
    $logichandler -> prepareTest($_POST["ExamType"]);
    $_SESSION["TestActive"] = 1;
    echo "<script> window.location.replace('testPage.php'); </script>";
}
else
{
    echo "<script>window.location.replace('mainmenu.php'); </script>";
}
