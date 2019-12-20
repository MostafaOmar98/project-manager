<?php

include_once 'Project.php';

$nameError = $workingHoursPerDayError = $costError = $startDateError = $dueDateError = $startingDayOfTheWeekError = "";
$name = $workingHoursPerDay = $cost = $startDate = $dueDate = $startingDayOfTheWeek = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") // a request happened
{
    $nameError = $workingHoursPerDayError = $costError = $startDateError = $dueDateError = $startingDayOfTheWeekError = "";
    $name = $workingHoursPerDay = $cost = $startDate = $dueDate = $startingDayOfTheWeek = "";

    $name = $_POST['name'];
    $workingHoursPerDay = $_POST['workingHoursPerDay'];
    $cost = $_POST['cost'];
    $startDate = $_POST['startDate'];
    $dueDate = $_POST['dueDate'];
    $startingDayOfTheWeek = $_POST['startingDayOfTheWeek'];

    $ok = true;

    if (strlen($_POST['name']) > 255)
    {
        $nameError .= "Project Name must be less than 255 characters ";
        $ok = false;
    }

    if (strcmp(gettype($name), "string") !== 0) {
        $nameError .= "Project name must be a string ";
        $ok .= false;
    }

    if (getProject($name) !== NULL) {
        $nameError = "A Project with this name already exists";
        $ok = false;
    }

    if ($_POST['workingHoursPerDay'] <= 0 || $_POST['workingHoursPerDay'] > 24) {
        $workingHoursPerDayError = "Working Hours Per Day Must be in Range [1, 24] ";
        $ok = false;
    }
    if (!is_numeric($workingHoursPerDay)){
        $workingHoursPerDayError .= "Working Hours Per Day must be integer ";
        $ok = false;
    }
    if ($_POST['cost'] < 0){
        $costError = "Cost can't be negative ";
        $ok = false;
    }
    if (!is_numeric($cost)) {
        $costError .= "Cost must be an integer ";
        $ok = false;
    }

    if ($_POST['dueDate'] < $_POST['startDate']){
        $dueDateError = "Due Date can't be before Start Date";
        $ok = false;
    }

    if ($ok)
    {
        $p = new Project($_POST['name'], $_POST['workingHoursPerDay'], $_POST['cost'], $_POST['startDate'], $_POST['dueDate'], $_POST['startingDayOfTheWeek']);
        insertProject($p);
        echo "Addition Successful!<br>";
        echo "<a href='index.php'>Return to Homepage</a><br>";
    }
}
?>

<form method="POST" action="addProject.php">
    Project Name: <input type="text" name="name" required value="<?php echo $name;?>"> <?php echo $nameError; ?><br>
    Working Hours Per Day: <input type="text" name="workingHoursPerDay" required value="<?php echo $workingHoursPerDay; ?>" > <?php echo $workingHoursPerDayError; ?> <br>
    Cost: <input type="text" name="cost" required value="<?php echo "$cost";?>"> <?php echo $costError; ?><br>
    Start Date: <input type="date" name="startDate" required value="<?php echo "$startDate";?>"> <?php echo $startDateError; ?><br>
    Due Date: <input type="date" name="dueDate" required value="<?php echo "$dueDate";?>"> <?php echo $dueDateError; ?><br>
    Starting Day of the Week: <select name="startingDayOfTheWeek">
        <option value="0" selected>Sunday</option>
        <option value="1">Monday</option>
        <option value="2">Tuesday</option>
        <option value="3">Wednesday</option>
        <option value="4">Thursday</option>
        <option value="5">Friday</option>
        <option value="6">Saturday</option>
    </select>
    <br> <br>
    <input type="submit" value="Add Project">
</form>
