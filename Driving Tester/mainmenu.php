<?php
require_once("LogicHandler.php");
session_start();
$logichandler = new LogicHandler();
$logichandler -> LoginGuard();
$logichandler -> testActiveGuard();

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

    <form action="generateTest.php" method="post">
        <select name="ExamType" id="" required>
            <option value="A">A Category -- Motorcycles & Mopeds</option>
            <option value="B">B Category -- Passenger Cars</option>
            <option value="B2">B2 Category -- Light Trucks / Vans</option>
            <option value="Behavioral">Behavior exam</option>
        </select>
        <input type="submit" value="Generate & Start test" name="TypeSubmission">
    </form>

    <form action="" method="post">
        <input type="hidden" name="LogoutToken" value="<?php echo $_SESSION["token"]; ?>">
        <input type="submit" name="LogoutReq" value="Log Out">
    </form>

    <a href="candidateTests.php"><button>View Tests</button></a>

</body>
</html>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>