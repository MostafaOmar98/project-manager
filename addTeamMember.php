<?php
set_time_limit(0);

include_once 'Project.php';
include_once 'Utility.php';
include_once 'Deliverable.php';
include_once 'TeamMember.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET')
{
    $pid = $_GET['pid'];
    $p = getProjectFromID($pid);
    $tmid = $name = $title = NULL;
    $tmidError = $nameError = $titleError = NULL;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $pid = $_POST['pid'];
    $p = getProjectFromID($pid);

    $tmidError = $nameError = $titleError = NULL;
    $tmid = $_POST['tmid'];
    $name = $_POST['name'];
    $title = $_POST['title'];

    $ok = true;
    $tmidError .= checkNumericLimits($tmid, 1, 1000000000);
    if (empty($tmidError) && getTeamMemberWithIdInProject($tmid, $pid) !== NULL)
        $tmidError .= "A Team Member with this id already exists. ";


    $nameError .= checkStrlen($name, 1, 255);
    $titleError .= checkStrlen($title, 1, 255);

    $ok &= empty($nameError);
    $ok &= empty($titleError);
    $ok &= empty($tmidError);

    if ($ok)
    {
        $tm = new TeamMember($tmid, $name, $title, $pid);
        insertTeamMember($tm);
        echo "Addition Sucessful!<br>";
        echo "<a href='viewProject.php?pid=$pid'>Return to Project Page </a>";
    }
}
$pName = $p->getName();
?>

<form action="addTeamMember.php" method="POST">
    ID: <input type='text' name='tmid' required value='<?php echo $tmid;?>'> <?php echo $tmidError;?> <br>
    Name: <input type='text' name='name' required value='<?php echo $name?>'> <?php echo $nameError;?><br>
    Title: <input type='text' name='title' value='<?php echo $title;?>'> <?php echo $titleError;?><br>
    <input type='hidden' name='pid' value='<?php echo $pid;?>'>
    <input type='submit' value='Add Team Member to Project <?php echo $pName;?>'>
</form>
