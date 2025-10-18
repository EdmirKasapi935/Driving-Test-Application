<?php
require_once("DBHandler.php");
require_once("Models\TestSheet.php");
require_once("Models\Question.php");
require_once("Models\TestSheet.php");

class TestHandler
{

    private $dbhandler;

    function __construct()
    {
        $this->dbhandler = new DBHandler();
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
            $selected_q = array_splice($q, 0, 6);
            $questions_list = array_merge($questions_list, $selected_q);
        }

        return $questions_list;
    }

    private function getExamQuestionsBehavioral()
    {
        $categories = $this->getBehavioralCategories();

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

        for ($i = 0; $i < $cnt; $i++) {
            $obj_q[$i] = new Question($questions[$i]["Q_ID"], $questions[$i]["Q_String"], $questions[$i]["Q_Answer"]);
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
                $_SESSION["Questions"] = $this->getExamQuestionsA();
                break;
            case ("B"):
                $_SESSION["Questions"] = $this->getExamQuestionsB();
                break;
            case ("B2"):
                $_SESSION["Questions"] = $this->getExamQuestionsB2();
                break;
            case ("Behavioral"):
                $_SESSION["Questions"] = $this->getExamQuestionsBehavioral();
                break;
        }

        $_SESSION["Current"] = 0;
        $_SESSION["Level"] = $examReq;

        unset($_POST["TypeSubmission"]);
        unset($_POST["ExamType"]);

        $_SESSION["Responses"] = $this->activateResponses(count($_SESSION["Questions"]));
    }

    private function activateResponses($len)
    {
        $res = array();

        for ($i = 0; $i < $len; $i++) {
            $res[$i] = "N/A";
        }

        return $res;
    }

    

    function evaluateTestResult($questions, $responses)
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

        return array("Right" => $rightcnt, "Wrong" => $wrongcnt);
    }

    function recordFullTest($score, $candidate, $level, $questions, $responses)
    {
        $this->recordTest($score, $candidate, $level);
        $this->recordResponses($this->getLatestTestID(), $questions, $responses);
    }

    private function recordTest($score, $candidate, $level)
    {
        $status = "";

        if ($level == "Behavioral") {

            if ($score["Wrong"] > 3) {
                $status = "FAILED";
            } else {
                $status = "PASSED";
            }

        } else {

            if ($score["Wrong"] > 4) {
                $status = "FAILED";
            } else {
                $status = "PASSED";
            }
            
        }

        

        $testData = array("Score" => $score["Right"], "Status" => $status, "Level" => $level, "Candidate" => $candidate->getID());
        $this->dbhandler->recordTest($testData);
    }

    private function recordResponses($testID, $questions, $responses)
    {
        $responseData = "";

        for ($i = 0; $i < count($questions); $i++) {

            $responseData = array("Alternative" => $responses[$i], "OrderNo" => $i, "Test" => $testID, "Question" => $questions[$i]->getID());
            $this->dbhandler->recordResponse($responseData);
        }
    }

    private function getLatestTestID()
    {
        $test = $this->dbhandler->getLatestTest();
        return $test["T_ID"];
    }

    //Test data retrieval
    function getUserTests($id)
    {
        $tests = $this->dbhandler->getUserTests($id);
        return $tests;
    }

    function getTestData($id)
    {
        $generalData = $this->dbhandler->getTestInfo($id);
        $responses = $this->dbhandler->getTestResponses($id);
        $questions = array();
        $explanations = array();
        foreach ($responses as $response) {
            $questions[$response["R_OrderNo"]] = $this->dbhandler->getQuestion($response["Q_ID"]);
            $explanations[$response["R_OrderNo"]] = $this->dbhandler->getExplanation($response["Q_ID"]);
        }

        return array("GeneralData" => $generalData, "Questions" => $questions, "Responses" => $responses, "Explanations" => $explanations );
    }

    

    function prepareTestSheet($tdata)
    {
        $testSheet = new TestSheet();
        $testSheet->setDate($tdata["GeneralData"]["T_Date"]);
        $testSheet->setLevelNum($tdata["GeneralData"]["L_ID"]);
        $testSheet->setScore($tdata["GeneralData"]["T_Score"]);
        $testSheet->setStatus($tdata["GeneralData"]["T_Status"]);
        $testSheet->setQuestions($this->questionsToObject($tdata["Questions"]));
        $testSheet->setResponses($tdata["Responses"]);
        $testSheet->setExplanations($tdata["Explanations"]);

        return $testSheet;
    }

    function renderTestNavButtons($questions, $responses, $currentBtn)
    {
        $cnt = count($questions);

        $buttonClass = "";
        $answeredClass = "answered-question-button";
        $unansweredClass = "unanswered-question-button";
        $currentClass = "current-question-button";

        for ($i = 0; $i < $cnt; $i++) {
            $current_cnt = $i + 1;

            if ($currentBtn == $i) {
                $buttonClass = $currentClass;
            } else {
                if ($responses[$i] != "N/A") {
                    $buttonClass = $answeredClass;
                } else {
                    $buttonClass = $unansweredClass;
                }
            }

            echo  "<form action='' method='post'>";
            echo  "<input type='submit' value='$current_cnt' name='questionSwitch' class='$buttonClass'>";
            echo  "</form>";
        }
    }

    function renderCandidateTests($id)
    {
        $tests = $this->getUserTests($id);
        $tests = array_reverse($tests);

        $index = count($tests);

        foreach ($tests as $test) {
            echo "<option value = " . $test["T_ID"] . ">" . $index . ". " . $test["T_Status"] . " -- " . $test["T_Date"] . "</option>";
            $index--;
        }
    }

    function renderTestSheet($id)
    {
        $tSheet = $this->prepareTestSheet($this->getTestData($id));
        $cnt = 1;

        echo "<section style='text-align:center; font-size:30px;'>";

        echo "LEVEL: " . $tSheet->getLevel() . "  --  SCORE: " . $tSheet->getScore() . " -- STATUS: " . $tSheet->getStatus();

        echo "</section>";

        $responses = $tSheet->getResponses();
        $questions = $tSheet->getQuestions();
        $explanations = $tSheet->getExplanations();

        foreach ($responses as $response) {
            $question = $questions[$response['R_OrderNo']];
            

            echo "<section style='margin: 5px; border: solid 2px;'>";

            if($this->getImageforQuestion($question->getID()) != null )
            {
              $image = $this->getImageforQuestion($question->getID());
              echo "<img src='Images/".$image["I_Name"]."' width='50px' height='50px'  />";
            }

            echo "<h2>" . $cnt . "." . $question->getString() . "<h3>";
            echo "<strong>" . "Right Answer: " . $question->getAnswer() . " -- Your Response: " . $response["R_Response"] . "</strong>";

            if($question->getAnswer() != $response["R_Response"])
            {
                $explanation = $explanations[$response['R_OrderNo']]['E_Explanation'];
                echo "<br>";
                echo "<strong>".$explanation."</strong>";
            }

            echo "</section>";

            $cnt++;
        }
    }

    function getImageforQuestion($id)
    {
        return $this->dbhandler->getImage($id);
    }
}
