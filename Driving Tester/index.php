<?php
session_start();
require_once("LogicHandler.php");
$logichandler = new LogicHandler();
$logichandler -> LogoutGuard();



if(isset($_POST["LoginReq"]))
{
    unset($_POST["LoginReq"]);
    $logichandler -> login($_POST["toLogin"]);
    
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
    <form action="" method="post">
        <select id="cars" name="toLogin">
            <?php
            $logichandler -> renderCandidateOptions();
            ?>
        </select>
        <br>
        <input type="submit" value="Log in" name="LoginReq">
    </form>

    <a href="register.php"><button style="margin-top: 10px;"> Register </button></a>



</body>

</html>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>
