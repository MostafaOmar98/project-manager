<?php
include "db-connection.php";
include "Project.php";

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
    while($row = $records->fetch_assoc())
    {
        $p = new Project($row['Name'], $row['WorkingHoursPerDay'], $row['Cost'], $row['StartDate'], $row['DueDate'], $row['StartingDayOfTheWeek']);
        $p->setID($row['ID']);
        array_push($ret, $p);
    }

    return $ret;
}

function projectExists($projectName)
{
    $conn = openConnection();

    $selectQuery = "SELECT * FROM project WHERE Name='$projectName'";
    $record = $conn->query($selectQuery);
    return $record->num_rows > 0;
}

?>
