<?php

class TestSheet{

    private $date;
    private $level;
    private $score;
    private $status;
    private $questions;
    private $responses;
    private $explanations;


    function getDate()
    {
        return $this->date;
    }

    function getLevel()
    {
        return $this->level;
    }

    function getScore()
    {
        return $this->score;
    }

    function getStatus()
    {
        return $this->status;
    }

    function getQuestions()
    {
        return $this->questions;
    }

    function getResponses()
    {
        return $this->responses;
    }

    function getExplanations()
    {
        return $this->explanations;
    }

    function setDate($newDate)
    {
        $this->date = $newDate;
    }
    
    function setLevel($newLevel)
    {
        $this->level = $newLevel;
    }

    function setLevelNum($newLevelNum)
    {
        $levels = array(
            1 => "A",
            2 => "B",
            3 => "B2",
            4 => "Behavioral"
        );

        $this->level = $levels[$newLevelNum];
    }

    function setScore($newScore)
    {
        $this->score = $newScore;
    }

    function setStatus($newStatus)
    {
        $this->status = $newStatus;
    }

    function setQuestions($newQuestions)
    {
        $this->questions = $newQuestions;
    }

    function setResponses($newResponses)
    {
        $this->responses = $newResponses;
    }

    function setExplanations($newExplanations)
    {
        $this->explanations = $newExplanations;
    }
     
}



?>