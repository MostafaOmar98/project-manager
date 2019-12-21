<?php

include_once 'Project.php';
include_once 'Utility.php';
include_once 'Task.php';
include_once 'Dependency.php';
include_once 'WorksOn.php';
include_once 'TeamMember.php';
/*
 * this page can be used to add a task to project or subtask to a task
 */
if ($_SERVER['REQUEST_METHOD'] == "GET") // coming from viewProject.php
{
    $pid = $_GET['pid'];
    $nameError = $workingDaysNeededError = $startDateError = $depsError = $teamError = NULL;
    $name = $workingDaysNeeded = $startDate = $deps = $team = NULL;
    $p = getProjectFromID($pid);

    $pTaskID = NULL;
    if (array_key_exists('pTaskID', $_GET))
        $pTaskID = $_GET['pTaskID'];
    $pTask = getTaskFromID($pTaskID);
}

if ($_SERVER['REQUEST_METHOD'] == "POST") // Tried to add Task
{
    $nameError = $workingDaysNeededError = $startDateError = $depsError = $teamError = NULL;

    $name = $_POST['name'];
    $workingDaysNeeded = $_POST['workingDaysNeeded'];
    $startDate = $_POST['startDate'];
    $deps = $_POST['deps'];
    $team = $_POST['team'];

    $pid = $_POST['pid'];
    $p = getProjectFromID($pid);

    $pTaskID = $pTask = NULL;
    if (array_key_exists('pTaskID', $_POST)) {
        $pTaskID = $_POST['pTaskID'];
        $pTask = getTaskFromID($pTaskID);
    }

    $ok = true;
    $nameError .= validateOneTaskExistence($name, $pid);

    $nameError .= checkStrlen($name, 1, 255);
    $workingDaysNeededError .= checkNumericLimits($workingDaysNeeded, 1, 9999);

    $workingDaysNeededError .= validateNewTaskWorkingDaysNeeded($p, $startDate, $workingDaysNeeded);
    $startDateError .= validateNewTaskStartDate($p, $startDate);

    if ($pTaskID !== NULL){
        $workingDaysNeededError .= validateNewSubtaskWorkingDays($pTask, $workingDaysNeeded);
        $startDateError .= validateNewSubtaskStartDate($pTask, $startDate);
    }else{
        $depTasks = getDepTasks($deps, $pid,$depsError);
        $startDateError .= validateTaskStartDateWithDep($depTasks, $startDate);
        $worksOnArr = validateWorksOn($team, $workingDaysNeeded, $teamError);
    }

    $ok &= empty($workingDaysNeededError);
    $ok &= empty($startDateError);
    $ok &= empty($nameError);
    $ok &= empty($depsError);
    $ok &= empty($teamError);

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
        if ($pTaskID === NULL) {
            $t = getTaskFromNameInProject($name, $pid);
            insertDependencies($t, $depTasks);
            insertWorksOnArr($worksOnArr, $t);
        }
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
    if ($pTaskID === NULL) {
        echo "Dependency Task Names (comma seperated): <input type='text' name='deps' size='100' value ='".$deps."'>". $depsError."<br>";
        echo "TeamMemberID and Working hours(Each team member id and his working hours are dash-seperated and 2 two team members are comma-seperated): <input type='text' name='team' size='150' value ='".$team."'>". $teamError."<br>";
        echo "<input type='submit' value='Add Task To Project " . $pName . "'><br>";
    }
    else {
        echo"<input type='text' name='pTaskID' hidden value='" . $pTaskID. "'>";
        echo "<input type='submit' value='Add Subtask To Task " . $pTaskName . "'>";
    }
    ?>
</form>
