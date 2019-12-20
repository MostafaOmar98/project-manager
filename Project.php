<?php


class Project
{
    private $ID, $name, $workingHoursPerDay, $cost, $startDate, $dueDate, $StartingDayOfTheWeek;

    public function __construct($name, $workingHoursPerDay, $cost, $startDate, $dueDate, $StartingDayOfTheWeek)
    {
        $this->name = $name;
        $this->workingHoursPerDay = $workingHoursPerDay;
        $this->cost = $cost;
        $this->startDate = $startDate;
        $this->dueDate = $dueDate;
        $this->StartingDayOfTheWeek = $StartingDayOfTheWeek;
    }

    public function setID($ID)
    {
        $this->ID = $ID;
    }

    public function getID()
    {
        return $this->ID;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getWorkingHoursPerDay()
    {
        return $this->workingHoursPerDay;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function getDueDate()
    {
        return $this->dueDate;
    }

    public function getStartingDayOfTheWeek()
    {
        return $this->StartingDayOfTheWeek;
    }

    public function __toString()
    {
        return "".$this->getName()." ".$this->getWorkingHoursPerDay()." ".$this->getCost()." ".$this->getStartDate()." ".$this->getDueDate()." ".$this->getStartingDayOfTheWeek();
    }


}

?>