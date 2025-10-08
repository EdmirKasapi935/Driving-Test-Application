<?php
require_once("DBHandler.php");

class LoginHandler
{

    private $dbhandler;

    function __construct()
    {
        $this->dbhandler = new DBHandler();
    }

    function logIn($id)
    {
        $_SESSION["Candidate"] = $this->dbhandler->getCandidateInfo($id);
        $this->generateUserKey();
        header("Location: mainmenu.php");
        exit;
    }

    private function generateUserKey()
    {
        $_SESSION["token"] = uniqid();
    }

    function logOut($tokenVal)
    {
        if ($tokenVal == $_SESSION["token"]) {
            session_destroy();
            header("Location: index.php");
            exit;
        }
    }

    function registerCandidate($name, $surname)
    {
        $clear_name = htmlspecialchars($name);
        $clear_surname = htmlspecialchars($surname);

        $this->dbhandler->register_candidate($clear_name, $clear_surname);
    }

    function renderCandidateOptions()
    {
        $candidates = $this->dbhandler->getCandidatesList();
        foreach ($candidates as $candidate) {
            echo "<option value=" . $candidate["Can_ID"] . " >" . $candidate["Can_Name"] . " " . $candidate["Can_Surname"] . " -- " . $candidate["Can_RegDate"] . "</option>";
        }
    }
}
