<?php 

class Question
{
    private $id;
    private $string;
    private $answer;

    function __construct($id, $string, $answer)
    {
        $this->id = $id;
        $this->string = $string;
        $this->answer = $answer;
    }

    function getID()
    {
        return $this->id;
    }

    function getString()
    {
        return $this->string;
    }

    function getAnswer()
    {
        return $this->answer;
    }
    
}

?>