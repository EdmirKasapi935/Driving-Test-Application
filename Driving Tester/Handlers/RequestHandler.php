<?php
require_once("LoginHandler.php");
require_once("TestHandler.php");
require_once("Models/Candidate.php");

class RequestHandler
{

    private $loginhandler;
    private $testhandler;

    public function __construct()
    {
        $this->loginhandler = new LoginHandler();
        $this->testhandler = new TestHandler();
    }

    function getCurrentCandidate()
    {
        $candidate = new Candidate($_SESSION["Candidate"]["Can_ID"], $_SESSION["Candidate"]["Can_Name"], $_SESSION["Candidate"]["Can_Surname"]);
        return $candidate;
    }

    function getCurrentQuestion()
    {
        $question = $this->testhandler->questionToObject($_SESSION["Questions"][$_SESSION["Current"]]);
        return $question;
    }

    //Request handling

    function handleLoginRequest()
    {
        if (isset($_POST["LoginReq"])) {
            unset($_POST["LoginReq"]);
            $this->loginhandler->login($_POST["toLogin"]);
        }
    }

    function handleLogoutRequest()
    {
        if (isset($_POST["LogoutReq"])) {

            unset($_POST["LogoutReq"]);
            $this->loginhandler->logOut($_POST["LogoutToken"]);
        }
    }

    function handleRegisterRequest()
    {
        if (isset($_POST["RegisterReq"])) {

            unset($_POST["RegisterReq"]);
            $this->loginhandler->registerCandidate($_POST['inputName'], $_POST["inputSurname"]);
        }
    }

    function handleTestGenerationRequest()
    {
        if (isset($_POST["TypeSubmission"])) {
            $this->testhandler->prepareTest($_POST["ExamType"]);
            $_SESSION["TestActive"] = 1;
            echo "<script> window.location.replace('testPage.php'); </script>";
        }
    }

    function handleQuestionSwitchRequest()
    {
        if (isset($_POST["questionSwitch"])) {
            $_SESSION["Current"] = $_POST["questionSwitch"] - 1;
            unset($_POST["questionSwitch"]);
        }
    }

    function handleResponseSubmission()
    {
        if (isset($_POST["responseSubmission"])) {
            $_SESSION["Responses"][$_SESSION["Current"]] = $_POST["questionResponse"];
            unset($_POST["responseSubmission"]);
        }
    }

    function handleTestFinishRequest()
    {
        if (!isset($_POST["FinishRequest"])) {

            if (isset($_SESSION["TestActive"])) {
                header("Location: testpage.php");
                exit;
            } else {
                header("Location: mainmenu.php");
                exit;
            }
        } else {
            unset($_SESSION["TestActive"]);

            $candidate = new Candidate($_SESSION["Candidate"]["Can_ID"], $_SESSION["Candidate"]["Can_Name"], $_SESSION["Candidate"]["Can_Surname"]);

            $result = $this->testhandler->evaluateTestResult($this->testhandler->questionsToObject($_SESSION["Questions"]), $_SESSION["Responses"]);
            $result["Status"] = $this->testhandler->recordFullTest($result, $candidate, $_SESSION["Level"], $this->testhandler->questionsToObject($_SESSION["Questions"]), $_SESSION["Responses"]);

            unset($_SESSION["Questions"]);
            unset($_SESSION["Responses"]);
            unset($_SESSION["Level"]);
            unset($_SESSION["Current"]);

            return $result;
        }
    }

    function handleViewRequest()
    {
        if (isset($_POST["ViewRequest"])) {

            $_SESSION["CurrentTestView"] = $_POST["test"];
            unset($_POST["ViewRequest"]);
        }
    }

    function handleGetToTestRequest()
    {
        if(isset($_POST["GetToTestRequest"]))
        {
            $candidate = $this->getCurrentCandidate();
            $_SESSION["CurrentTestView"] = $this -> testhandler -> getLatestTestID($candidate->getID() );

            unset($_POST["GetToTestRequest"]);
        }
    }

    //Guard functions

    function loginGuard()
    {
        if (!isset($_SESSION["token"])) {
            header("Location: index.php");
            exit;
        }
    }

    function logoutGuard()
    {
        if (isset($_SESSION["token"])) {
            header("Location: mainmenu.php");
            exit;
        }
    }

    function testActiveGuard()
    {
        if (isset($_SESSION["TestActive"])) {
            header("Location: testPage.php");
            exit;
        }
    }

    function testInaciveGuard()
    {
        if (!isset($_SESSION["TestActive"])) {
            header("Location: mainmenu.php");
            exit;
        }
    }

    function noCacheGuard()
    {
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header("Expires: 0");
    }

    //Rendering

    function renderCandidatesList()
    {
        $this->loginhandler->renderCandidateOptions();
    }

    function renderTestsList()
    {
        $candidate = $this->getCurrentCandidate();
        $this->testhandler->renderCandidateTests($candidate->getID());
    }

    function renderQuestionButtons()
    {
        $questions = $_SESSION["Questions"];
        $responses = $_SESSION["Responses"];
        $current = $_SESSION["Current"];

        $this->testhandler->renderTestNavButtons($questions, $responses, $current);
    }

    function renderCurrentTestSheet()
    {
        if (isset($_SESSION["CurrentTestView"])) {
            $this->testhandler->renderTestSheet($_SESSION["CurrentTestView"]);
        }
    }

    function renderImageForTest($id)
    {
        $image = $this->testhandler->getImageforQuestion($id);
        
        if($image != null)
        {
            $picture = $image["I_Name"];
        }
        else
        {
            $picture = "no-image.png";
        }
    
        echo "<img src='Images/".$picture."' class='test-image' />";
    }

}
