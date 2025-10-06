<?php
require_once("LogicHandler.php");
session_start();
$logichandler = new LogicHandler();
$logichandler->LoginGuard();
$candidate = new Candidate($_SESSION["Candidate"]["Can_ID"], $_SESSION["Candidate"]["Can_Name"], $_SESSION["Candidate"]["Can_Surname"]);

if (isset($_POST["ViewRequest"])) {

    $_SESSION["CurrentTestView"] = $_POST["test"];
    unset($_POST["ViewRequest"]);
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

        <select name="test">
            <?php
            $logichandler->renderCandidateTests($candidate->getID());
            ?>
            <input type="submit" value="View Test" name="ViewRequest">

        </select>


    </form>

    <a href="mainmenu.php"><button>Back to Menu</button></a>
 
    <section>
        <?php
        $logichandler -> renderTestSheet($_SESSION["CurrentTestView"]);
        ?>
    </section>

</body>

</html>
<script>
    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
</script>