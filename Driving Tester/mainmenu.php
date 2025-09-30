<?php
require_once("LogicHandler.php");
session_start();
$logichandler = new LogicHandler();
$logichandler -> LoginGuard();

if(isset($_POST["LogoutReq"]))
{
    unset($_POST["Logout"]);
    $logichandler -> logOut($_POST["LogoutToken"]);
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
    <h1>Main Menu</h1>

    <?php
     
     

    ?>

    <form action="" method="post">
        <input type="hidden" name="LogoutToken" value="<?php echo $_SESSION["token"]; ?>">
        <input type="submit" name="LogoutReq" value="Log Out">
    </form>

</body>
</html>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>