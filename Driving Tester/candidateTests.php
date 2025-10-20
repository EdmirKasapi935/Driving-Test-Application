<?php
session_start();
require_once("Handlers/RequestHandler.php");

$requesthandler = new RequestHandler();
$requesthandler->noCacheGuard();
$requesthandler->loginGuard();
$requesthandler->testActiveGuard();

$requesthandler->handleGetToTestRequest();
$requesthandler->handleViewRequest();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Driving Tester - Test Sheets</title>
</head>

<body class="page-background" style="background-image: url(Wallpapers/Wp2.jpeg);">

    <section class="test-view-form">
        <form action="" method="post">

            <section class="form-group">
                <select name="test" class="form-input" required>
                    <?php $requesthandler->renderTestsList(); ?>
                </select>
            <input type="submit" value="View Test" class="main-form-button" name="ViewRequest">
            </section>
        </form>
        <a href="mainmenu.php"><button class="normal-button">Back to Menu</button></a>
    </section>

    <section class="sheet-paper">
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