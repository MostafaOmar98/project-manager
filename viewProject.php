<?php
include_once 'Project.php';
include_once 'Task.php';

$pid = $_GET['pid'];
$p = getProjectFromID($pid);
$pName = $p->getName();
echo "<h1>$pName</h1>";
viewAllTasksHierarchy($pid);

function viewTaskTree(Task $t)
{
    $id = $t->getID();
    $name = $t->getName();
    $tasks = getAllSubtasks($id);

    echo "<li>";
    echo "<a href='viewTask?tid=$id'>$name</a>";
    echo "<ul>";
    for ($i = 0; $i < sizeof($tasks); $i += 1)
    {
        $tChild = $tasks[$i];
        viewTaskTree($tChild);
    }
    echo "</ul>";
    echo "</li>";
}

function viewAllTasksHierarchy($pid)
{
    $tasks = getAllTasksForProject($pid);

    echo "<div id='tasksDiv'>";
    echo "<ul>";
    for ($i = 0; $i < sizeof($tasks); $i += 1) {
        $t = $tasks[$i];
        viewTaskTree($t);
    }
    echo "</ul>";
    echo "<br><br>";
    echo "<a href='addTask.php?pid=$pid'>Add New Task For This Project</a>";
    echo "</div>";
}


?>