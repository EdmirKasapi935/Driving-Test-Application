<?php

class Candidate
{
    private $id;
    private $name;
    private $surname;

    function __construct($id, $name, $surname)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
    }

    function getID()
    {
        return $this->id;
    }

    function getName()
    {
        return $this->name." ".$this->surname; ;
    }
}

?>
