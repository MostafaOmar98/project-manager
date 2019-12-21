<?php
include_once 'Project.php';
include_once 'Task.php';

$tid = $_GET['tid'];
$t = getTaskFromID($tid);
$pid = $t->getPID();
$p = getProjectFromID($pid);
$pName = $p->getName();
$tName = $t->getName();
echo "<h1>$pName</h1>";
echo "<br>";
echo "<h2>$tName</h2>";
viewAllTasksHierarchy();

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
    echo "<div id='tasksDiv'>";
    echo "<ul>";
    for ($i = 0; $i < sizeof($tasks); $i += 1) {
        $t = $tasks[$i];
        viewTaskTree($t);
    }
    echo "</ul>";
    echo "<br><br>";
    echo "<a href='addTask.php?pid=$pid&pTaskID=$tid'>Add New Subtask For This Task</a>";
    echo "</div>";
}

?>