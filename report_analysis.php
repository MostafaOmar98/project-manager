<?php
set_time_limit(0);
include_once 'Project.php';
include_once 'Task.php';
include_once 'CompletedTask.php';
include_once 'Utility.php';
echo "<table border='black solid'>";
echo "<tr>";
echo "<th>Task Name</th> <th>Planned Finish Time</th> <th>Actual Finish Time</th> <th> Is Finished on time?</th>";
echo "</tr>";
$pid = $_GET['pid'];
$tasks = getMajorTasks($pid);
foreach($tasks as $t){
    echo "<tr>";
    echo "<td>".$t->getName()."</td>";
    $plannedEndDate = addDaysToDate($t->getStartDate(), $t->getWorkingDaysNeeded());
    echo "<td>".$plannedEndDate."</td>";

    $actual = getActualTask($t->getId());
    if ($actual === NULL){
        echo "<td> Not Yet Completed</td>";
        echo "<td> -</td>";
    }else{
        echo "<td>".$actual->getEndDate()."</td>";
        $finishedOnTime = $actual->getEndDate() <= $plannedEndDate;
        echo "<td>";
        if ($finishedOnTime)
            echo "YES";
        else
            echo "NO";
        echo "</td>";
    }
    echo "</tr>";
}

echo "</table>";

?>
