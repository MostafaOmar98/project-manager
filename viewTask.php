<?php
set_time_limit(0);
include_once 'Project.php';
include_once 'Task.php';
include_once 'Utility.php';
include_once 'Dependency.php';

$tid = $_GET['tid'];
$t = getTaskFromID($tid);
$pid = $t->getPID();
$p = getProjectFromID($pid);
$pName = $p->getName();
$tName = $t->getName();
echo "<h1>$pName</h1>";
echo "<br>";
echo "<h2>$tName</h2>";
showTaskInfo($t, $p);
viewAllTasksHierarchy();
viewDependencyRelations($t);

function showTaskInfo(Task $t, Project $p)
{
    echo "Name: ".$t->getName();
    echo "<br>";
    echo "Number of Working days needed: ".$t->getWorkingDaysNeeded();
    echo "<br>";
    echo "Number of Working Hours needed: ".$t->getWorkingDaysNeeded()*$p->getWorkingHoursPerDay();
    echo "<br>";
    echo "Start Date: ".$t->getStartDate();
    echo "<br>";
    echo "Due Date: ".addDaysToDate($t->getStartDate(), $t->getWorkingDaysNeeded());
    echo "<br>";
}

function viewTaskTree(Task $t)
{
    $id = $t->getID();
    $name = $t->getName();
    $tasks = getAllSubtasks($id);

    echo "<li>";
    echo "<a href='viewTask.php?tid=$id'>$name</a>";
    echo "<ul>";
    for ($i = 0; $i < sizeof($tasks); $i += 1)
    {
        $tChild = $tasks[$i];
        viewTaskTree($tChild);
    }
    echo "</ul>";
    echo "</li>";
}

function viewAllTasksHierarchy()
{
    global $pid, $tid;
    $tasks = getAllSubtasks($tid);
    echo "<h2>List of Subtasks</h2>";
    echo "<div id='tasksDiv'>";
    echo "<ul>";
    for ($i = 0; $i < sizeof($tasks); $i += 1) {
        $t = $tasks[$i];
        viewTaskTree($t);
    }
    echo "</ul>";
    echo "<br><br>";
    echo "</div>";
}

function viewDependencyRelations($t)
{
    viewDependency($t);
    viewDependent($t);
}

function viewDependency($t)
{
    echo "<h2>This task depends on</h2>";
    $tasks = getAllDependencyTasks($t);
    echo "<ul>";
    for ($i = 0; $i < sizeof($tasks); $i += 1) {
        echo "<li>";
        $depT = $tasks[$i];
        $id = $depT->getId();
        $name = $depT->getName();
        echo "<a href='viewTask.php?tid=$id'>$name</a>";
        echo "</li>";
    }
    echo "</ul>";
    echo "<br><br>";
}

function viewDependent($t)
{
    echo"<h2> Tasks that depend on this task </h2>";
    $tasks = getAllDependentTasks($t);
    echo "<ul>";
    for ($i = 0; $i < sizeof($tasks); $i += 1) {
        echo "<li>";
        $depT = $tasks[$i];
        $id = $depT->getId();
        $name = $depT->getName();
        echo "<a href='viewTask.php?tid=$id'>$name</a>";
        echo "</li>";
    }
    echo "</ul>";
    echo "<br><br>";
}

echo "<a href='addTask.php?pid=$pid&pTaskID=$tid'>Add New Subtask For This Task</a>";
?>