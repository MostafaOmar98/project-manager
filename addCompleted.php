<?php
set_time_limit(0);
include_once 'Project.php';
include_once 'Utility.php';
include_once 'Task.php';
include_once 'CompletedTask.php';
$nameError = $startDateError = $endDateError = NULL;

if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $pid = $_GET['pid'];
    $p = getProjectFromID($pid);
    $name = $startDate = $endDate = NULL;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $pid = $_POST['pid'];
    $p = getProjectFromID($pid);

    $name = $_POST['name'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];

    $nameError .= checkStrlen($name, 1, 255);
    if ($startDate > $endDate)
        $startDateError .= "Start date of task can't be after it's end date. ";
    $t = getTaskFromNameInProject($name, $pid);
    if ($t == NULL)
        $nameError .= "Task $name does not exist in this project. ";

    $ok = empty($nameError) && empty($startDateError) && empty($endDateError);

    if ($ok)
    {
        $c = new CompletedTask($t->getId(), $startDate, $endDate);
        insertCompletedTask($c);
        echo "Recorded Successfuly!<br>";
        echo "<a href='viewProject.php?pid=$pid'>Return to Project Page</a>";
    }
}

$pName = $p->getName();

?>


<form action='addCompleted.php' method='POST'>
    Task Name: <input type='text' name='name' required value='<?php echo $name?>'> <?php echo $nameError?><br>
    Start Date: <input type='date' name='startDate' required value='<?php echo $startDate?>'> <?php echo $startDateError?><br>
    End Date: <input type='date' name='endDate' required value='<?php echo $endDate?>'> <?php echo $endDateError?><br>
    <input type='text' hidden name='pid' value='<?php echo $pid?>'>
    <input type='submit' value='Add record to <?php echo $pName?>'>
</form>
