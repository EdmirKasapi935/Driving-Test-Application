<?php
session_start();
require_once("Handlers/RequestHandler.php");

$requesthandler = new RequestHandler();
$requesthandler->loginGuard();
$requesthandler->testInaciveGuard();

$requesthandler->handleQuestionSwitchRequest();
$requesthandler->handleResponseSubmission();

$question = $requesthandler->getCurrentQuestion();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Driving Tester - Test</title>
</head>

<body class="page-background" style="background: linear-gradient(rgba(85, 139, 245, 1), rgba(58, 86, 142, 1));">

    <nav class="button-nav-section">

        <?php
        $requesthandler->renderQuestionButtons();
        ?>

    </nav>

    <hr>

    <section style="display: flex; flex-direction: row;">
        <section class="test-image-section">
            <?php

            $requesthandler->renderImageForTest($question->getID());

            ?>
        </section>

        <section class="question-section">

            <h2 style="margin-top: 25px" class="question-text"> <?php echo $question->getString(); ?> </h2>

            <form action="" method="post">

                <div class="question-alternatives">
                    <div class="form-group question-alternative">
                        <input type="radio" name="questionResponse" id="" value="True" class="question-radio" required <?php if ($_SESSION["Responses"][$_SESSION["Current"]] == "True") echo "checked" ?>> <label class="question-alternative-label">True</label>
                    </div>

                    <div class="form-group question-alternative">
                        <input type="radio" name="questionResponse" id="" value="False" class="question-radio" required <?php if ($_SESSION["Responses"][$_SESSION["Current"]] == "False") echo "checked" ?>> <label class="question-alternative-label">False</label>
                    </div>
                </div>

                <input type="submit" name="responseSubmission" value="Submit Response" class="main-form-button">
            </form>

            <form action="testResult.php" method="post">
                <input type="submit" value="Finish Test" name="FinishRequest" class="danger-button"  onclick="return confirm('Are you sure you want to finish the test?')">
            </form>

        </section>


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