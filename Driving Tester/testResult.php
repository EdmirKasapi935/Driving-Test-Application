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
    <title>Document</title>
</head>

<body>

    <h2><?php echo "Right Answers: " . $result["Right"]; ?></h2>
    <h2><?php echo "Wrong Answers: " . $result["Wrong"]; ?></h2>

    <a href="mainmenu.php"><button>Back to Menu</button></a>

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