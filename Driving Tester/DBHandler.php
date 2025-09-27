<?php

class DBHandler{

    private $pdo;

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