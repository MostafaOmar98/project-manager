<?php

include_once 'Project.php';
include_once 'Utility.php';
include_once 'Task.php';

if ($_SERVER['REQUEST_METHOD'] == "GET") // coming from viewProject.php
{
    $pid = $_GET['pid'];
    $nameError = $workingDaysNeededError = $startDateError = "";
    $name = $workingDaysNeeded = $startDate = "";
    $p = getProjectFromID($pid);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") // Tried to add Task
{
    $nameError = $workingDaysNeededError = $startDateError = "";
    $name = $workingDaysNeeded = $startDate = "";

    $name = $_POST['name'];
    $workingDaysNeeded = $_POST['workingDaysNeeded'];
    $startDate = $_POST['startDate'];
    $pid = $_POST['pid'];
    $p = getProjectFromID($pid);

    $ok = true;

    if (strlen($name) > 255)
    {
        $nameError .= "Task Name must be less than 255 characters ";
        $ok = false;
    }

    if (getTaskWithName($name) !== NULL) {
        $nameError .= "A Task with this name in this project already exists ";
        $ok = false;
    }

    if ($workingDaysNeeded <= 0) {
        $workingDaysNeededError .= "Working Days Needed must be greater than 0 ";
        $ok = false;
    }
    if (!is_numeric($workingDaysNeeded)){
        $workingDaysNeededError .= "Working Days Needed must be integer ";
        $ok = false;
    }

    if ($startDate < $p->getStartDate()){
        $startDateError .= "Start Date of Task can't be before Project Start Date";
        $ok = false;
    }

    $dueDate = addDaysToDate($startDate, $workingDaysNeeded);
    if ($dueDate > $p->getDueDate()){
        $workingDaysNeededError .= "Task can't be planned to finish after project due date ";
        $ok = false;
    }

    if ($ok)
    {
        $t = new Task($name, $workingDaysNeeded, $startDate, $pid);
        insertTask($t);
        echo "Addition Successful!<br>";
        echo "<a href='viewProject.php?pid=$pid'>Return to Project Page</a><br>";
    }
}

$pName = $p->getName();
?>

<form method="POST" action="addTask.php">
    Task Name: <input type="text" name="name" required value="<?php echo $name;?>"> <?php echo $nameError; ?><br>
    Working Days Needed: <input type="text" name="workingDaysNeeded" required value="<?php echo $workingDaysNeeded; ?>" > <?php echo $workingDaysNeededError; ?> <br>
    Start Date: <input type="date" name="startDate" required value="<?php echo "$startDate";?>"> <?php echo $startDateError; ?><br>
    <input type="text" name="pid" hidden value="<?php echo $pid?>">
    <input type="submit" value="Add Task To Project <?php echo $pName?>">
</form>
