<?php
session_start();
require_once("Handlers/RequestHandler.php");

$requesthandler = new RequestHandler();
$requesthandler->noCacheGuard();
$requesthandler->logoutGuard();

$requesthandler->handleLoginRequest();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Driving Tester - Login</title>
</head>

<body class="page-background" style="background-image: url(Wallpapers/WP1.jpeg);">

    <h1 class="page-title">Welcome to the driving tester!</h1>
    <h2 class="page-subtitle"> Select your name below </h2>

    <section class="login-form">
        <form action="" method="post">

            <div class="form-group" style="margin-top: 5px;">
                <label for="Users" class="form-label">User: </label>
                <select id="Users" name="toLogin" class="form-input">
                    <?php
                    $requesthandler->renderCandidatesList();
                    ?>
                </select>

            </div>

            <input type="submit" value="Log in" name="LoginReq" class="main-form-button">
        </form>

        <a href="register.php"><button class="normal-button"> Register Page</button></a>
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