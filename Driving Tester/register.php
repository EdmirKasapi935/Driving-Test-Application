<?php
session_start();
require_once("LogicHandler.php");
$logichandler = new LogicHandler();
$logichandler -> LogoutGuard();

if (isset($_POST["RegisterReq"])) {
   
    unset($_POST["RegisterReq"]);
    $logichandler -> registerCanidate();
    
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
    <h1>This is the register page</h1>

    <section style="width: 300px; height: 300px; margin-left: auto; margin-right: auto;margin: auto; background-color: cadetblue; border: 10px solid; border-color:darkcyan; border-radius: 10px; text-align:center;">
        <form action="" method="post">
            <input type="text" name="inputName" id="" style="margin-top: 31px;" required><br>
            <input type="text" name="inputSurname" id="" style="margin-top: 10px;" required><br>
            <input type="submit" value="Register" style="margin-top: 10px;" name="RegisterReq">
        </form>

        <a href="/index.php"><button>Main menu</button></a>

    </section>



</body>

</html>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>