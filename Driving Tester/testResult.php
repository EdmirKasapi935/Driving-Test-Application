<?php
session_start();
require_once("LogicHandler.php");
$logichandler = new LogicHandler();
$logichandler->LoginGuard();

$rightcnt = 0;
$wrongcnt = 0;

$questions = $_SESSION["Questions"];
$responses = $_SESSION["Responses"];

for ($i = 0; $i < count($questions); $i++) {

    if (!isset($responses[$i])) {
        $wrongcnt++;
    } else {

        if ($questions[$i]["Q_Answer"] != $responses[$i]) {
            $wrongcnt++;
        } else {
            $rightcnt++;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <h2><?php echo "Right Answers: " . $rightcnt; ?></h2>
    <h2><?php echo "Wrong Answers: " . $wrongcnt; ?></h2>

</body>

</html>