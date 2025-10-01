<?php
require_once("DBHandler.php");
class LogicHandler
{

    private $dbhandler;

    function __construct()
    {
        $this->dbhandler = new DBHandler();
    }

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


    function getExamQuestionsA()
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

    function getExamQuestionsB()
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

    function getExamQuestionsB2()
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

    function getExamQuestionsBehavioral()
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



    function login($id)
    {
        $candidate = $this->dbhandler->getCandidateInfo($id);
        $_SESSION["candidate"] = $candidate["Can_ID"];
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

    function getBehavioralCategories2()
    {
        $behavioral = $this->dbhandler->getCategories("Behavioral");
        return array_splice($behavioral, 0, 4);
    }
}
