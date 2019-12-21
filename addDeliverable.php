<?php

include_once 'Project.php';
include_once 'Utility.php';
include_once 'Deliverable.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $pid = $_GET['pid'];
    $p = getProjectFromID($pid);
    $name = $description = NULL;
    $nameError = $descriptionError = NULL;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $pid = $_POST['pid'];
    $p = getProjectFromID($pid);

    $nameError = $descriptionError = NULL;
    $name = $_POST['name'];
    $description = $_POST['description'];

    $ok = true;

    if (getDeliverableWithNameInProject($name, $pid) !== NULL)
        $nameError .= "A deliverable with this name in this project already exists. ";

    $nameError .= checkStrlen($name, 1, 255);
    $descriptionError .= checkStrlen($description, 0, 1024);

    $ok &= empty($nameError);
    $ok &= empty($descriptionError);

    if ($ok)
    {
        $d = new Deliverable($name, $description, $pid);
        insertDeliverable($d);
        echo "Addition Sucessful!<br>";
        echo "<a href='viewProject.php?pid=$pid'>Return to Project Page </a>";
    }
}
$pName = $p->getName();
?>

<form action="addDeliverable.php" method="POST">
    Name: <input type='text' name='name' required value='<?php echo $name?>'> <?php echo $nameError;?><br>
    Description: <input type='text' name='description' size='100' value='<?php echo $description;?>'> <?php echo $descriptionError;?><br>
    <input type='hidden' name='pid' value='<?php echo $pid;?>'>
    <input type='submit' value='Add Deliverable to Project <?php echo $pName;?>'>
</form>
