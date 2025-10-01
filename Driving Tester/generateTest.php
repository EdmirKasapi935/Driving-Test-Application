<?php
require_once('LogicHandler.php');
session_start();
$logichandler = new LogicHandler();
$logichandler->LoginGuard();

echo ($_POST["TypeSubmission"]);
echo($_POST["ExamType"]);

if(isset($_POST["TypeSubmission"])) {
    switch ($_POST["ExamType"]) {
        case ("A"):
            $_SESSION["Questions"] = $logichandler -> getExamQuestionsA();
            break;
        case ("B"):
            $_SESSION["Questions"] = $logichandler -> getExamQuestionsB();
            break;
        case ("B2"):
            $_SESSION["Questions"] = $logichandler -> getExamQuestionsB2();
            break;
        case ("Behavioral"):
            $_SESSION["Questions"] = $logichandler -> getExamQuestionsBehavioral();
            break;
    }

    unset($_POST["TypeSubmission"]);
    unset($_POST["ExamType"]);

    echo "<script> window.location.replace('testPage.php'); </script>";
}
