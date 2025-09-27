<?php
require("DBHandler.php");

$dbhandler = new DBHandler();

var_dump($_POST);

if (isset($_POST["RegisterReq"])) {
    $name = $_POST["Name"];
    $surname = $_POST["Surname"];

    echo "here";

    $dbhandler->register_candidate($name, $surname);
    unset($_POST["RegisterReq"]);
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
            <input type="text" name="Name" id="" style="margin-top: 31px;" required><br>
            <input type="text" name="Surname" id="" style="margin-top: 10px;" required><br>
            <input type="submit" value="Register" style="margin-top: 10px;" name="RegisterReq">
        </form>
    </section>



</body>

</html>

<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>