<?php
include "db-connection.php";
include "Project.php";

function insertProject(Project $p)
{
    /*
     * $p should be validated before calling this function
     */
    $conn = openConnection();

    $insertQuery = "INSERT INTO project (Name, WorkingHoursPerDay, Cost, StartDate, DueDate, StartingDayOfTheWeek)
            VALUES ('$p->getName()', $p->getWorkingHoursPerDay(), $p->getCost(), $p->getWorkingDays(), '$p->getStartDate()', '$p->getDueDate()', $p->getStartingDayOfTheWeek()";
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

?>
