<?php
session_start();
require_once("Handlers/RequestHandler.php");

$requesthandler = new RequestHandler();
$requesthandler->noCacheGuard();
$requesthandler->loginGuard();

$result = $requesthandler->handleTestFinishRequest();

$requesthandler->testActiveGuard(); //in case the finishRequest gets manipulated
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Driving Tester - Result</title>
</head>

<body class="page-background" style="background-image: url(Wallpapers/WP3.jpeg);">

    <h1 class="page-title">Test Result</h1>

    <h3 class="page-subtitle">Your responses have been evaluated and recorded for later reviews</h3>

    <section class="result-section">

        <h2 class="answer-text right-answer-color"><?php echo "Right Answers: " . $result["Right"]; ?></h2>
        <h2 class="answer-text wrong-answer-color"><?php echo "Wrong Answers: " . $result["Wrong"]; ?></h2>

        <hr class="result-line-separator">

        <small class="status-text"> Status: </small><strong class="status-text status-<?php echo $result['Status']?>-text "> <?php echo $result["Status"] ?> </strong>

    </section>

    <form action="candidateTests.php" method="post" style="display: block; width: fit-content; margin-left: auto; margin-right: auto; margin-top: 5px;">
    <input type="submit" class="normal-button" value="View Test" name="GetToTestRequest">
    </form>

    <a href="mainmenu.php" style="display: block; width: fit-content; margin-left: auto; margin-right: auto;"><button class=" normal-button" style="margin-top: 15px;">Back to Menu</button></a>

</body>


</html>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
<script>
    window.addEventListener('pageshow', function(event) {
        if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            // This forces a reload if the page is loaded from the bfcache
            window.location.reload();
        }
    });
</script>