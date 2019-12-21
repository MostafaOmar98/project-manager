<?php

include_once 'Project.php';
include_once 'Utility.php';
include_once 'Task.php';

/*
 * this page can be used to add a task to project or subtask to a task
 */
if ($_SERVER['REQUEST_METHOD'] == "GET") // coming from viewProject.php
{
    $pid = $_GET['pid'];
    $nameError = $workingDaysNeededError = $startDateError = NULL;
    $name = $workingDaysNeeded = $startDate = NULL;
    $p = getProjectFromID($pid);

    $pTaskID = NULL;
    if (array_key_exists('pTaskID', $_GET))
        $pTaskID = $_GET['pTaskID'];
    $pTask = getTaskFromID($pTaskID);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") // Tried to add Task
{
    $nameError = $workingDaysNeededError = $startDateError = NULL;

    $name = $_POST['name'];
    $workingDaysNeeded = $_POST['workingDaysNeeded'];
    $startDate = $_POST['startDate'];

    $pid = $_POST['pid'];
    $p = getProjectFromID($pid);

    $pTaskID = $pTask = NULL;
    if (array_key_exists('pTaskID', $_POST)) {
        $pTaskID = $_POST['pTaskID'];
        $pTask = getTaskFromID($pTaskID);
    }

    $ok = true;

    if (getTaskFromName($name) !== NULL) {
        $nameError .= "A Task with this name in this project already exists ";
        $ok = false;
    }

    $nameError .= checkStrlen($name, 1, 255);
    $workingDaysNeededError .= checkNumericLimits($workingDaysNeeded, 1, 9999);

    $workingDaysNeededError .= validateNewTaskWorkingDaysNeeded($p, $startDate, $workingDaysNeeded);
    $startDateError .= validateNewTaskStartDate($p, $startDate);

    if ($pTaskID !== NULL){
        $workingDaysNeededError .= validateNewSubtaskWorkingDays($pTask, $workingDaysNeeded);
        $startDateError .= validateNewSubtaskStartDate($pTask, $startDate);
    }

    $ok &= empty($workingDaysNeededError);
    $ok &= empty($startDateError);
    $ok &= empty($nameError);

    if ($ok)
    {
        $t = new Task($name, $workingDaysNeeded, $startDate, $pid);
        echo "Addition Successful!<br>";
        if ($pTaskID !== NULL) {
            $t->setPTaskID($pTaskID);
            echo "<a href='viewTask.php?tid=$pTaskID'>Return to parent task page</a><br>";
        }
        else
            echo "<a href='viewProject.php?pid=$pid'>Return to Project Page</a><br>";
        insertTask($t);
    }
}

$pName = $p->getName();
if ($pTask !== NULL)
    $pTaskName = $pTask->getName();
?>

<form method="POST" action="addTask.php">
    Task Name: <input type="text" name="name" required value="<?php echo $name;?>"> <?php echo $nameError; ?><br>
    Working Days Needed: <input type="text" name="workingDaysNeeded" required value="<?php echo $workingDaysNeeded; ?>" > <?php echo $workingDaysNeededError; ?> <br>
    Start Date: <input type="date" name="startDate" required value="<?php echo $startDate;?>"> <?php echo $startDateError; ?><br>
    <input type="text" name="pid" hidden value="<?php echo $pid?>">
    <?php
    if ($pTaskID === NULL)
        echo"<input type='submit' value='Add Task To Project ".$pName."'>";
    else {
        echo"<input type='text' name='pTaskID' hidden value='" . $pTaskID. "'>";
        echo "<input type='submit' value='Add Subtask To Task " . $pTaskName . "'>";
    }
    ?>
</form>
