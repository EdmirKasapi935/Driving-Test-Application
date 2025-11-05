<?php
session_start();
require_once("Handlers/RequestHandler.php");

$requesthandler = new RequestHandler();
$requesthandler->loginGuard();
$requesthandler->testInaciveGuard();

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
            <img src='Images/no-image.png' class='test-image' id="test-image" />
        </section>

        <section class="question-section">

            <h2 style="margin-top: 25px" id="question-title" class="question-text"> <?php //echo $question->getString(); ?> </h2>

            <section>

                <div class="question-alternatives">
                    <div class="form-group question-alternative">
                        <input type="radio" name="questionResponse" id="ansT" value="True" class="question-radio" onclick="assignResponse(this.value)"> <label class="question-alternative-label">True</label>
                    </div>

                    <div class="form-group question-alternative">
                        <input type="radio" name="questionResponse" id="ansF" value="False" class="question-radio" onclick="assignResponse(this.value)"> <label class="question-alternative-label">False</label>
                    </div>
                </div>

            </section>

            <form action="testResult.php" method="post" style="margin-top: 30px;" id="finish-form">
                <input type="hidden" name="testResponses" id="test-responses">
                <input type="hidden" id="finish-requester">
                <input type="submit" value="Finish Test" name="FinishRequest" class="danger-button" id="finish-button" onclick="return confirm('Are you sure you want to finish the test?')">
            </form>

        </section>


    </section>

    <section class="timer-box">

     <p class="timer-title">Time Left</p>
     <hr class="divider">
     <p id="timer" class="timer-display">40:00</p>
      
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
<script>
    var current = <?php echo json_encode($_SESSION["Current"]); ?>;
    var questions = <?php echo json_encode($requesthandler->transferQuestions()); ?>;
    var responses = <?php echo json_encode($_SESSION["Responses"]); ?>;
    const images = <?php echo json_encode($requesthandler->perpareImagesForTest()); ?>;

    const finishForm = document.getElementById('finish-form');
    const responseHolder = document.getElementById('test-responses');
    const testImage = document.getElementById('test-image');

    var questionText = document.getElementById('question-title');
    var currentBtn = document.getElementById(current);

    window.addEventListener('load', function() {

        changeQuestion(current);
        timer();
    });

    finishForm.addEventListener('submit', function() {

        responseHolder.value = JSON.stringify(responses);

    });

    function changeQuestion(id) {
        current = id;
        questionText.innerHTML = questions[current];

        changeImage(id);
        trackButton(id);
        trackResponse();
    }

    function trackButton(id) {
        var prevIndex = currentBtn.id;

        const basicStyle = 'question-button';
        const currentStyle = basicStyle + ' ' + 'current-question-button';
        const answeredStyle = basicStyle + ' ' + 'answered-question-button';
        const unansweredStyle = basicStyle + ' ' + 'unanswered-question-button';

        var replacementStyle; //= (responses[current] === 'undefined' ) ? answeredStyle : unansweredStyle;

        if (responses[prevIndex] === 'N/A') {
            replacementStyle = unansweredStyle;
        } else {
            replacementStyle = answeredStyle;
        }

        currentBtn.setAttribute('class', replacementStyle);

        currentBtn = document.getElementById(current);
        currentBtn.setAttribute('class', currentStyle);

    }

    function trackResponse() {
        const trueCheckbox = document.getElementById("ansT");
        const falseCheckbox = document.getElementById("ansF");

        trueCheckbox.checked = (responses[current] === "True");
        falseCheckbox.checked = (responses[current] === "False");
    }

    function assignResponse(response) {
        responses[current] = response;
    }

    function changeImage(current) {
        var imageString = "Images/" + images[current];
        testImage.src = imageString;
    }

    function timer() {
        var requester = document.getElementById('finish-requester');
        var timerText = document.getElementById('timer'); 

        var min = 40;
        var totalSec = 40 * 60;

        var timer = setInterval(function() {

            
            var sec = totalSec % 60;

            var minstring;
            var secstring;

            if(min < 10)
            {
                minstring = '0' + min;
            }
            else
            {
                minstring = min;
            }

            if(sec < 10)
            {
                secstring = '0' + sec;
            }
            else
            {
                secstring = sec;
            }

            

            timerText.innerHTML = minstring + ':' + secstring;
            totalSec--;

            if(sec == 0)
            {
                min--;
            }

            if (min < 0) {
                clearInterval(timer);
                requester.setAttribute('name','FinishRequest');
                requester.setAttribute('value', 'True');
                document.getElementById('finish-form').requestSubmit();
            }
        }, 1000);
    }

</script>