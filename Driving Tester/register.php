<?php
session_start();
require_once("Handlers/RequestHandler.php");

$requesthandler = new RequestHandler();
$requesthandler->noCacheGuard();
$requesthandler->logoutGuard();

$requesthandler->handleRegisterRequest();

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Driving Tester - Register</title>
</head>

<body>
    <h1 class="page-title">Register Page</h1>
    <h2 class="page-subtitle"> Please fill the form below properly to register </h2>

    <section class="register-form">
        <form action="" method="post">
            <div class="form-group" style="margin-top: 30px;">
                 <label for="inputName" class="form-label">Name: </label>
                 <input type="text" name="inputName" id="inputName" class="form-input" required>
            </div>

            <div class="form-group">
              <label for="inputSurname" class="form-label">Surname: </label> 
              <input type="text" name="inputSurname" id="inputSurname" class="form-input" required>
            </div>
           
            <input type="submit" value="Register" class="main-form-button" name="RegisterReq">

        </form>
        <a href="/index.php"><button class="normal-button">Main menu</button></a>

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