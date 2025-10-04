<?php
require_once("DBHandler.php");
require_once("Models/Candidate.php");
require_once("Models/Question.php");
class LogicHandler
{

    private $dbhandler;

    function __construct()
    {
        $this->dbhandler = new DBHandler();
    }

    //User registration
    function registerCanidate()
    {
        $clear_name = filter_input(INPUT_POST, "inputName", FILTER_SANITIZE_SPECIAL_CHARS);
        $clear_surname = filter_input(INPUT_POST, "inputSurame", FILTER_SANITIZE_SPECIAL_CHARS);

        $this->dbhandler->register_candidate($clear_name, $clear_surname);
    }

    function renderCandidateOptions()
    {
        $candidates = $this->dbhandler->getCandidatesList();
        foreach ($candidates as $candidate) {
            echo "<option value=" . $candidate["Can_ID"] . " >" . $candidate["Can_Name"] . " " . $candidate["Can_Surname"] . " -- " . $candidate["Can_RegDate"] . "</option>";
        }
    }

    //exam quetions preparation
    private function getExamQuestionsA()
    {
        $categories = array_merge($this->getACategories(), $this->getSharedCategories());

        $questions_list = array(); // empty array

        foreach ($categories as $category) {
            $q = $this->dbhandler->getCategoryQuestions($category["C_ID"]);
            shuffle($q);
            $selected_q = array_splice($q, 0, 5);
            $questions_list = array_merge($questions_list, $selected_q);
        }

        return $questions_list;
    }

    private function getExamQuestionsB()
    {
        $categories = array_merge($this->getBCategories(), $this->getSharedCategories());

        $questions_list = array(); // empty array

        foreach ($categories as $category) {
            $q = $this->dbhandler->getCategoryQuestions($category["C_ID"]);
            shuffle($q);
            $selected_q = array_splice($q, 0, 5);
            $questions_list = array_merge($questions_list, $selected_q);
        }

        return $questions_list;
    }

    private function getExamQuestionsB2()
    {
        $categories = array_merge($this->getB2Categories(), $this->getSharedCategories());

        $questions_list = array(); // empty array

        foreach ($categories as $category) {
            $q = $this->dbhandler->getCategoryQuestions($category["C_ID"]);
            shuffle($q);
            $selected_q = array_splice($q, 0, 5);
            $questions_list = array_merge($questions_list, $selected_q);
        }

        return $questions_list;
    }

    private function getExamQuestionsBehavioral()
    {
        $categories = $this -> getBehavioralCategories();

        $questions_list = array(); // empty array

        foreach ($categories as $category) {
            $q = $this->dbhandler->getCategoryQuestions($category["C_ID"]);
            shuffle($q);
            $selected_q = array_splice($q, 0, 5);
            $questions_list = array_merge($questions_list, $selected_q);
        }

        return $questions_list;
    }

    private function getACategories()
    {
        $a = $this->dbhandler->getCategories("A");
        shuffle($a);
        return array_splice($a, 0, 5);
    }

    private function getBCategories()
    {
        $b =  $this->dbhandler->getCategories("B");
        shuffle($b);
        return array_splice($b, 0, 5);
    }

    private function getB2Categories()
    {
        $b2 = $this->dbhandler->getCategories("B2");
        shuffle($b2);
        return array_splice($b2, 0, 5);
    }

    private function getBehavioralCategories()
    {
        $behavioral = $this->dbhandler->getCategories("Behavioral");
        return array_splice($behavioral, 0, 4);
    }

    private function getSharedCategories()
    {
        $shared =  $this->dbhandler->getCategories("Shared");
        shuffle($shared);
        return array_splice($shared, 0, 3);
    }

    function questionsToObject($questions)
    {
        $cnt = count($questions);
        $obj_q = array();

        for($i=0; $i<$cnt; $i++)
        {
           $obj_q[$i] = new Question($questions[$i]["Q_ID"], $questions[$i]["Q_String"], $questions[$i]["Q_ID"]);
        }

        return $obj_q;

    }

    function questionToObject($question)
    {
        $question_obj = new Question($question["Q_ID"], $question["Q_String"], $question["Q_Answer"]); 
        return $question_obj;    
    }

    //Test preparation and evaluation
    function prepareTest($examReq)
    {
         switch ($examReq) {
        case ("A"):
            $_SESSION["Questions"] = $this -> getExamQuestionsA();
            break;
        case ("B"):
            $_SESSION["Questions"] = $this -> getExamQuestionsB();
            break;
        case ("B2"):
            $_SESSION["Questions"] = $this -> getExamQuestionsB2();
            break;
        case ("Behavioral"):
            $_SESSION["Questions"] = $this -> getExamQuestionsBehavioral();
            break;
    }

    $_SESSION["Current"] = 0;
    $_SESSION["Level"] = $examReq; 

    unset($_POST["TypeSubmission"]);
    unset($_POST["ExamType"]);

    $_SESSION["Responses"] = $this -> activateResponses(count($_SESSION["Questions"]));
    }

    private function activateResponses($len)
    {
        $res = array();

        for($i=0; $i<$len; $i++)
        {
            $res[$i] = "N/A";
        }

        return $res;
    }

    function renderTestNavButtons($questions, $responses, $currentBtn)
    {
        $cnt = count($questions);

        $buttonStyle = "";
        $basicStyle = "margin: 2px;";
        $currentstyle = $basicStyle." background-color: #c383faff;";
        $unansweredStyle = $basicStyle."background-color:  #fb6e6eff;";
        $answeredStyle = $basicStyle."background-color: #98FF98;";
       
        for($i = 0; $i < $cnt; $i++) {
            $current_cnt = $i + 1;

            if ($currentBtn == $i) {
               $buttonStyle = $currentstyle;
            } else {
                if ($responses[$i] != "N/A" ) {
                    $buttonStyle = $answeredStyle;
                } else {
                    $buttonStyle = $unansweredStyle;
                }
            }

            echo  "<form action='' method='post'>";
            echo  "<input type='submit' value=" . $current_cnt . " name='questionSwitch' style='" . $buttonStyle . "'>";
            echo  "</form>";
        }
    }

    function evaluateTestResult( $questions, $responses)
    {
        $rightcnt = 0;
        $wrongcnt = 0;

        for ($i = 0; $i < count($questions); $i++) {

            if ($questions[$i]->getAnswer() != $responses[$i]) {
                $wrongcnt++;
            } else {
                $rightcnt++;
            }
        }

        return array("Right" => $rightcnt, "Wrong" => $wrongcnt );
    }

    
    function recordTest($score, $candidate, $level)
    {
        $status = "";

        if ($score["Wrong"] > 4) {
            $status = "FAILED";
        } else {
            $status = "PASSED";
        } 

        $testData = array( "Score" => $score["Right"], "Status" => $status, "Level" => $level, "Candidate" => $candidate -> getID() );
        $this -> dbhandler -> recordTest($testData);

    }

    function recordResponses($testID, $questions, $responses)
    {
        $responseData= "";

         for ($i = 0; $i < count($questions); $i++) {

            $responseData = array("Alternative" => $responses[$i], "OrderNo" => $i, "Test" => $testID, "Question" => $questions[$i] -> getID());
            $this -> dbhandler -> recordResponse($responseData);
        }
    }

    function getLatestTestID()
    {
        $test = $this -> dbhandler -> getLatestTest();
        return $test["T_ID"]; 
    }


    //User login and logout

    function login($id)
    {
        $_SESSION["Candidate"] = $this->dbhandler->getCandidateInfo($id);
        $this->generateUserKey();
        echo "<script> window.location.replace('mainmenu.php') </script>";
    }

    function logOut($tokenVal)
    {
        if ($tokenVal == $_SESSION["token"]) {
            session_destroy();
            echo "<script> window.location.replace('index.php') </script>";
        }
    }

    function LoginGuard()
    {
        if (!isset($_SESSION["token"])) {
            echo "<script> window.location.replace('index.php') </script>";
        }
    }

    function LogoutGuard()
    {
        if (isset($_SESSION["token"])) {
            echo "<script> window.location.replace('mainmenu.php') </script>";
        }
    }

    private function generateUserKey()
    {
        $_SESSION["token"] = uniqid();
    }

}
