<?php
set_time_limit(0);
include_once 'Project.php';
include_once 'Task.php';
include_once 'Deliverable.php';
include_once 'TeamMember.php';
$pid = $_GET['pid'];
$p = getProjectFromID($pid);
$pName = $p->getName();
echo "<h1>$pName</h1>";
showProjectInfo($p);
viewAllTeamMembers($pid);
viewAllDeliverables($pid);
viewAllTasksHierarchy($pid);

echo "<a href='addCompleted.php?pid=$pid'>Record actual working hours</a><br><br>";
echo "<a href='viewPlanChart.php?pid=$pid'>View Plan Gantt Chart</a><br><br>";
echo "<a href='viewActualChart.php?pid=$pid'>View Actual Gantt Chart</a><br><br>";
echo "<a href='report_analysis.php?pid=$pid'>View Project Report Analysis</a>";

function showProjectInfo(Project $p)
{
    echo "Name: ".$p->getName();
    echo "<br>";
    echo "Working Hours Per Day: ".$p->getWorkingHoursPerDay();
    echo "<br>";
    echo "Cost: ".$p->getCost();
    echo "<br>";
    echo "Start Date: ".$p->getStartDate();
    echo "<br>";
    echo "DueDate: ".$p->getDueDate();
    echo "<br>";
    echo "Starting Day of The Week: ";
    if ($p->getStartingDayOfTheWeek() == 0)
        echo "Sunday";
    else
        echo "Monday";
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
        echo "<a href='viewDeliverable.php?did=$did&pid=$pid'>".$d->getName()."</a>";
        echo "</li>";
    }
    echo "</ul>";

    echo "<a href='addDeliverable.php?pid=$pid'>"."Add New Deliverable to this Project"."</a>";
    echo "</div>";
}

function viewAllTeamMembers($pid)
{
    $team = getTeamMemberWithPid($pid);

    echo "<div id='teamMembersDiv'>";
    echo "<h2>List of Team Members</h2>";
    echo "<ul>";
    for ($i = 0; $i < sizeof($team); $i += 1)
    {
        $tm = $team[$i];
        $tmid = $tm->getId();
        echo "<li>";
        echo "<a href='viewTeamMember.php?tmid=$tmid&pid=$pid'>".$tm->getName()."</a>";
        echo "</li>";
    }
    echo "</ul>";

    echo "<a href='addTeamMember.php?pid=$pid'>"."Add New Team Member to this Project"."</a>";
    echo "</div>";
    echo "<br>";
}


?>
