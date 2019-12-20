<?php

include_once 'db-connection.php';


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
        return "" . $this->getName() . " " . $this->getWorkingHoursPerDay() . " " . $this->getCost() . " " . $this->getStartDate() . " " . $this->getDueDate() . " " . $this->getStartingDayOfTheWeek();
    }


}



function insertProject(Project $p)
{
    /*
     * $p should be validated before calling this function
     */
    $conn = openConnection();

    $name = $p->getName();
    $workingHoursPerDay = $p->getWorkingHoursPerDay();
    $cost = $p->getCost();
    $startDate = $p->getStartDate();
    $dueDate = $p->getDueDate();
    $startingDayOfTheWeek = $p->getStartingDayOfTheWeek();

    $insertQuery = "INSERT INTO project (Name, WorkingHoursPerDay, Cost, StartDate, DueDate, StartingDayOfTheWeek)
        VALUES ('$name', $workingHoursPerDay, $cost, '$startDate', '$dueDate', $startingDayOfTheWeek)";
    $conn->query($insertQuery);

    closeConnection($conn);
}



function getAllProjects()
{
    /*
     * Returns a PHP Array of Projects
     */
    $conn = openConnection();

    $selectQuery = "SELECT * FROM project";
    $records = $conn->query($selectQuery);
    $ret = array();
    while ($row = $records->fetch_assoc()) {
        $p = new Project($row['Name'], $row['WorkingHoursPerDay'], $row['Cost'], $row['StartDate'], $row['DueDate'], $row['StartingDayOfTheWeek']);
        $p->setID($row['ID']);
        array_push($ret, $p);
    }

    return $ret;
}



function getProject($projectName)
{
    /*
     * Returns Project object or NULL if not found
     */
    $conn = openConnection();

    $selectQuery = "SELECT * FROM project WHERE Name='$projectName'";
    $record = $conn->query($selectQuery);
    if ($record->num_rows === 0)
        return NULL;
    $row = $record->fetch_assoc();
    $p = new Project($row['Name'], $row['WorkingHoursPerDay'], $row['Cost'], $row['StartDate'], $row['DueDate'], $row['StartingDayOfTheWeek']);
    return $p;
}

?>