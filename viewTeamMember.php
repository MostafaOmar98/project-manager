<?php
include_once 'TeamMember.php';
include_once 'WorksOn.php';
$tmid = $_GET['tmid'];
$member = getTeamMemberWithID($tmid);
echo "ID: ".$member->getId();
echo "<br>";
echo "Name: ".$member->getName();
echo "<br>";
echo "Title: ".$member->getTitle();
echo "<br>";
viewMemberTasks($member);

function viewMemberTasks($member)
{
    $worksOn = getTasksForTeamMember($member);
    echo "<h2>Tasks</h2>";
    echo "<ul>";
    for ($i = 0; $i < sizeof($worksOn); $i += 1) {
        echo "<li>";
        $w = $worksOn[$i];
        $t = $w->getTask();
        $tid = $t->getId();
        $name = $t->getName();
        echo "<a href='viewTask.php?tid=$tid'>$name</a>";
        echo " - ".$w->getHours()." Hours";
        echo "</li>";
    }
    echo "</ul>";
    echo "<br><br>";
}
$pid = $_GET['pid'];
echo "<a href='viewProject.php?pid=$pid'>Return to Project Page</a>";

?>
