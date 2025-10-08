<?php
session_start();
require_once("Handlers/RequestHandler.php");

$requesthandler = new RequestHandler();
$requesthandler->loginGuard();
$requesthandler->testInaciveGuard();

$requesthandler->handleQuestionSwitchRequest();
$requesthandler->handleResponseSubmission();

$question = $requesthandler->getCurrentQuestion();

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

$requesthandler->renderQuestionButtons();

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
<script>
    window.addEventListener('pageshow', function (event) {
        if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            // This forces a reload if the page is loaded from the bfcache
            window.location.reload();
        }
    });
</script>