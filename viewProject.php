<?php
include_once 'Project.php';
include_once 'Task.php';
include_once 'Deliverable.php';
include_once 'TeamMember.php';
$pid = $_GET['pid'];
$p = getProjectFromID($pid);
$pName = $p->getName();
echo "<h1>$pName</h1>";
viewAllTasksHierarchy($pid);
viewAllDeliverables($pid);
viewAllTeamMembers($pid);
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

function viewAllTasksHierarchy($pid)
{
    $tasks = getMajorTasks($pid);

    echo "<div id='tasksDiv'>";
    echo "<h2>List of Tasks</h2>";
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

function viewAllDeliverables($pid)
{
    $deliverables = getAllDeliverables($pid);

    echo "<div id='deliverablesDiv'>";
    echo "<h2>List of Deliverables</h2>";
    echo "<ul>";
    for ($i = 0; $i < sizeof($deliverables); $i += 1)
    {
        $d = $deliverables[$i];
        $did = $d->getId();
        echo "<li>";
        echo "<a href='viewDeliverable.php?did=$did'>".$d->getName()."</a>";
        echo "</li>";
    }
    echo "</ul>";

    echo "<a href='addDeliverable.php?pid=$pid'>"."Add New Deliverable to this Project"."</a>";
    echo "</div>";
}

function viewAllTeamMembers($pid)
{
    $team = getAllTeamMembers
}

?>