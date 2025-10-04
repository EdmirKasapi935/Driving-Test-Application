<?php
session_start();
require_once("LogicHandler.php");
$logichandler = new LogicHandler();
$logichandler->LoginGuard();

$candidate = new Candidate($_SESSION["Candidate"]["Can_ID"], $_SESSION["Candidate"]["Can_Name"], $_SESSION["Candidate"]["Can_Surname"]);

$result = $logichandler ->evaluateTestResult($logichandler -> questionsToObject($_SESSION["Questions"]), $_SESSION["Responses"]);
$logichandler -> recordTest($result, $candidate, $_SESSION["Level"]);
$logichandler -> recordResponses($logichandler->getLatestTestID(), $logichandler -> questionsToObject($_SESSION["Questions"]), $_SESSION["Responses"] );

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <h2><?php echo "Right Answers: " . $result["Right"]; ?></h2>
    <h2><?php echo "Wrong Answers: " . $result["Wrong"]; ?></h2>

</body>

</html>