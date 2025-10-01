<?php
require_once("DBHandler.php");
class LogicHandler
{

    private $dbhandler;

    function __construct()
    {
        $this -> dbhandler = new DBHandler();
    }

    function registerCanidate()
    {
        $clear_name = filter_input(INPUT_POST, "inputName", FILTER_SANITIZE_SPECIAL_CHARS );
        $clear_surname = filter_input(INPUT_POST, "inputSurame", FILTER_SANITIZE_SPECIAL_CHARS );

        $this -> dbhandler -> register_candidate($clear_name, $clear_surname);
    }

    function renderCandidateOptions()
    {
        $candidates = $this -> dbhandler ->getCandidatesList();
        foreach($candidates as $candidate)
            {
                echo "<option value=".$candidate["Can_ID"]." >".$candidate["Can_Name"]." ".$candidate["Can_Surname"]." -- ".$candidate["Can_RegDate"]."</option>";
            }
    }


    function getAExamQuestions()
    {
        $categories = array_merge($this -> getACategories(), $this -> getSharedCategories());
        
        $questions_list = array(); // empty array

        foreach($categories as $category)
        {
          $q = $this -> dbhandler -> getCategoryQuestions($category["C_ID"]);
          $questions_list += $q; 
        }

        return $questions_list;
    }
    

    private function getACategories()
    {
        $a = $this -> dbhandler -> getCategories("A");
        return $a;
    }

    private function getBCategories()
    {
        $b =  $this -> dbhandler -> getCategories("B");
        
        return $b;
    }

    private function getB2Categories()
    {
        $b2 = $this -> dbhandler -> getCategories("B2");
        return $b2;
    }

    private function getBehavioralCategories()
    {
        return $this -> dbhandler -> getCategories("Behavioral");
    }

    private function getSharedCategories()
    {
        return $this -> dbhandler -> getCategories("Shared");
    }

   
    
    function login($id)
    {
       $candidate = $this -> dbhandler -> getCandidateInfo($id);
       $_SESSION["candidate"] = $candidate["Can_ID"];
       $this -> generateUserKey();
       echo "<script> window.location.replace('mainmenu.php') </script>";
    }

    function logOut($tokenVal)
    {
        if ($tokenVal == $_SESSION["token"]) 
        {
            session_destroy();
            echo "<script> window.location.replace('index.php') </script>";
        }
    }

    function LoginGuard()
    {
      if(!isset($_SESSION["token"]))
      {
          echo "<script> window.location.replace('index.php') </script>";
      }
    }

    function LogoutGuard()
    {
        if(isset($_SESSION["token"]))
      {
          echo "<script> window.location.replace('mainmenu.php') </script>";
      }
    }

    private function generateUserKey()
    {
        $_SESSION["token"] = uniqid();
    }


   

}

?>