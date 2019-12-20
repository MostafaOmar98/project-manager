<?php
include "db-connection.php";
include "Project.php";

function insertProject(Project $p)
{
    $conn = openConnection();

    $insertQuery = "INSERT INTO project (Name, WorkingHoursPerDay, Cost, StartDate, DueDate, StartingDayOfTheWeek)
            VALUES ('$p->getName()', $p->getWorkingHoursPerDay(), $p->getCost(), $p->getWorkingDays(), '$p->getStartDate()', '$p->getDueDate()', $p->getStartingDayOfTheWeek()";
    $conn->query($insertQuery);

    closeConnection($conn);
}

?>
