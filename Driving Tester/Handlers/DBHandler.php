<?php

class DBHandler{

    private $pdo;
    private $levels = array(
        "A" => 1,
        "B" => 2,
        "B2" => 3,
        "Behavioral" => 4,
        "Shared" => 5
    );

    function __construct()
    {
        $this->pdo = new PDO("sqlite:DrivingDB.db");
    }

    function register_candidate($name, $surname)
    {
        if($this -> checkNull($name, $surname) == true)
        {
          echo "<script> alert('Please fill the fields properly!') </script>";
          return;
        }

        $date = date("d/m/Y");
        $query = "INSERT INTO Candidates(Can_Name, Can_Surname, Can_RegDate)
                  VALUES (:name, :surname, '$date')";          
        $statement = $this -> pdo -> prepare($query);
        $statement -> bindValue(":name", $name, PDO::PARAM_STR);
        $statement -> bindValue(":surname", $surname, PDO::PARAM_STR);
        $success = $statement -> execute();

        if($success)
        {
            echo "<script> alert('Registration successful') </script>";
        }
        else
        {
            echo "<script> alert('Error') </script>";
        }
        
    }

    function getCandidatesList()
    {
        $query = "SELECT * FROM Candidates";
        $statement = $this -> pdo -> query($query);
        $candidates = $statement -> fetchAll(PDO::FETCH_ASSOC);

        return $candidates;
    }

    function getCandidateInfo($id)
    {
        $query = "SELECT * FROM Candidates Where Can_ID=".$id;
        $statement = $this -> pdo -> query($query);
        $candidate = $statement -> fetch(PDO::FETCH_ASSOC);

        return $candidate;
    }

    function getCategories($levelinput)
    {
        $level = $this -> levels[$levelinput];

        $query = "SELECT * FROM Categories WHERE L_ID = $level";
        $statement = $this -> pdo -> query($query);
        $categories = $statement -> fetchAll(PDO::FETCH_ASSOC);

        return $categories;
    }

    function getCategoryQuestions($input)
    {
        $query = "SELECT * FROM Questions WHERE C_ID =".$input;
        $statement = $this -> pdo -> query($query);
        $questions = $statement -> fetchAll(PDO::FETCH_ASSOC);

        return $questions;
    }

    function recordTest($testData)
    {
        $score = $testData["Score"];
        $status = $testData["Status"];
        $date = date("d/m/Y");
        $level = $this -> levels[$testData["Level"]];
        $candidate = $testData["Candidate"];

        $query = "INSERT INTO Tests(T_Score, T_Status, T_Date, L_ID, Can_ID) VALUES ($score, '$status', '$date', $level, $candidate);";
        $statement = $this -> pdo -> prepare($query);
        $statement -> execute();
    }

    function getLatestTest()
    {
        $query = "SELECT * FROM Tests ORDER BY T_ID DESC LIMIT 1";
        $statement = $this -> pdo -> query($query);
        $test = $statement -> fetch(PDO::FETCH_ASSOC);

        return $test;
    }

    function getTestInfo($id)
    {
        $query = "SELECT * FROM Tests WHERE T_ID=".$id;
        $statement = $this -> pdo -> query($query);
        $test = $statement -> fetch(PDO::FETCH_ASSOC);

        return $test;
    }

    function recordResponse($responseData)
    {
        $alternative = $responseData["Alternative"];
        $orderNo = $responseData["OrderNo"];
        $test = $responseData["Test"];
        $question = $responseData["Question"];

        $query = "INSERT INTO Responses(R_Response, R_OrderNo, T_ID, Q_ID) VALUES('$alternative', $orderNo, $test, $question);";
        $statement = $this -> pdo -> prepare($query);
        $statement -> execute();
    }

    function getUserTests($uID)
    {
        $query = "SELECT * FROM Tests WHERE Can_ID=".$uID;
        $stmnt = $this -> pdo -> query($query);
        $tests = $stmnt -> fetchAll(PDO::FETCH_ASSOC);

        return $tests;
    }

    function getTestResponses($tID)
    {
        $query = "SELECT * FROM Responses WHERE T_ID=".$tID;
        $stmnt = $this -> pdo -> query($query);
        $responses = $stmnt -> fetchAll(PDO::FETCH_ASSOC);

        return $responses;
    }

    function getQuestion($id)
    {
        $query = "SELECT * FROM Questions WHERE Q_ID=".$id;
        $statement = $this -> pdo -> query($query);
        $question = $statement -> fetch(PDO::FETCH_ASSOC);

        return $question;

    }

    function getExplanation($id)
    {
        $query = "SELECT * FROM Explanations WHERE E_ID=".$id;
        $stmnt = $this -> pdo -> query($query);
        $explanation = $stmnt -> fetch(PDO::FETCH_ASSOC);

        return $explanation;
    }

    private function checkNull(...$params)
    {
        foreach($params as $param)
        {
            if(trim($param) == "")
            {
                return true;
            }
        }

        return false;
    }


}

?>