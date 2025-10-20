<?php
session_start();
require_once("Handlers/RequestHandler.php");

$requesthandler = new RequestHandler();
$requesthandler->noCacheGuard();
$requesthandler->loginGuard();
$requesthandler->testActiveGuard();

$requesthandler->handleLogoutRequest();
$requesthandler->handleTestGenerationRequest();

$candidate = $requesthandler->getCurrentCandidate();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Driving Tester - Main menu</title>
</head>

<body class="page-background" style="background-image: url(Wallpapers/WP4.jpeg);">
    <h1 class="page-title">Main Menu</h1>
    <h2 class="page-subtitle"> Welcome, <?php echo $candidate->getName() ?></h2>

    <section class="menu-test-form-section">

        <h4 class="menu-form-title">Select your test's category</h4>

        <form action="" method="post" class="">
            <select name="ExamType" id="" class="form-input" required>
                <option value="A">A Category -- Motorcycles & Mopeds</option>
                <option value="B">B Category -- Passenger Cars</option>
                <option value="B2">B2 Category -- Light Trucks / Vans</option>
                <option value="Behavioral">Behavior exam</option>
            </select>
            <input type="submit" value="Generate & Start test" name="TypeSubmission" class="main-form-button" >
        </form>

    </section>

    <a href="candidateTests.php"><button class="normal-button">View Tests</button></a>

    <form action="" method="post">
        <input type="hidden" name="LogoutToken" value="<?php echo $_SESSION["token"]; ?>">
        <input type="submit" name="LogoutReq" class="danger-button" value="Log Out">
    </form>



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