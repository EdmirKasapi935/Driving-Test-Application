<?php
session_start();
require_once("Handlers/RequestHandler.php");

$requesthandler = new RequestHandler();
$requesthandler->noCacheGuard();
$requesthandler->loginGuard();
$requesthandler->testActiveGuard();

$requesthandler->handleViewRequest();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <form action="" method="post">

        <select name="test">
            <?php $requesthandler->renderTestsList(); ?>
        </select>
        <input type="submit" value="View Test" name="ViewRequest">

    </form>

    <a href="mainmenu.php"><button>Back to Menu</button></a>

    <section>
        <?php $requesthandler->renderCurrentTestSheet(); ?>
    </section>

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