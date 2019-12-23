<?php
set_time_limit(0);
?>

<head>
    <title>Project Manager</title>
</head>
<body>
<div id="header">
    <h1>Welcome to Project Manager</h1>
    <br>
</div>
<div id="addNewProject">
    <a href="/project-manager/addProject.php">Add New Project</a>
    <br> <br>
</div>
</body>

<?php
include_once "Project.php";


echo "<h1> List Of Current Projects: </h1>";
echo "<ol>";
$projects = getAllProjects();
for ($i = 0; $i < sizeof($projects); $i += 1)
{
    echo "<li>";
    $p = $projects[$i];
    $id = $p->getID();
    $name = $p->getName();
    $DueDate = $p->getDueDate();
    echo "<a href='viewProject.php?pid=$id'>$name</a>";
    echo "<br><br>";
    echo "</li>";
}
echo "</ol";

?>
