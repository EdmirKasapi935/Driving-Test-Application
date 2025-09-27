<?php

class DBHandler{

    private $pdo;

    function __construct()
    {
        $this->pdo = new PDO("sqlite:DrivingDB.db");
    }

    function register_candidate($name, $surname)
    {
        if($this -> checkNull($name, $surname))
        {
          return;
        }

        $date = date("d/m/Y");
        $query = "INSERT INTO Candidates(Can_Name, Can_Surname, Can_RegDate)
                  VALUES ('$name', '$surname', '$date')";
        $statement = $this -> pdo -> prepare($query);
        $success = $statement -> execute();
        $statement -> closeCursor();

        if($success)
        {
            echo "<script> alert('Registration successful!') </script>";
        }
        else
        {
            echo "<script> alert('Error') </script>";
        }
        
    }

    function checkNull(...$params)
    {
        foreach($params as $param)
        {
            if($param == "")
            {
                return true;
            }
        }

        return false;
    }

}

?>