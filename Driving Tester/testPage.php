<?php
session_start();
require_once("LogicHandler.php");
$logichandler = new LogicHandler();
$logichandler -> LoginGuard();
$logichandler -> testInaciveGuard();

if(isset($_POST["questionSwitch"]))
{
  $_SESSION["Current"] = $_POST["questionSwitch"] - 1;
  unset($_POST["questionSwitch"]);
}

if(isset($_POST["responseSubmission"]))
{
  $_SESSION["Responses"][$_SESSION["Current"]] = $_POST["questionResponse"];
  unset($_POST["responseSubmission"]);
}

$question = $logichandler -> questionToObject($_SESSION["Questions"][$_SESSION["Current"]]);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>


<div style="display: flex;">

<?php

$logichandler -> renderTestNavButtons($_SESSION["Questions"], $_SESSION["Responses"], $_SESSION["Current"]);

?>

</div>

<h2 style="margin-top: 25px"> <?php echo $question->getString(); ?> </h2>


<form action="" method="post">
<input type="radio" name="questionResponse" id="" value="True" required> <label>True</label>
<input type="radio" name="questionResponse" id="" value="False" required> <label>False</label> <br>
<input type="submit" name="responseSubmission" value="Confirm">
</form>

<body>

<form action="testResult.php" method="post">
  <input type="submit" value="FinishTest" name="FinishRequest">
</form>

</body>
</html>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>