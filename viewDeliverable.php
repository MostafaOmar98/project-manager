<?php
set_time_limit(0);
include_once "Deliverable.php";
$did = $_GET['did'];
$d = getDeliverableWithId($did);
echo "Deliverable Name: ".$d->getName();
echo "<br>";
echo "Deliverable Description: ".$d->getDescription();
echo "<br>";

$pid = $_GET['pid'];
echo "<a href='viewProject.php?pid=$pid'>Return to project Page</a>";
echo "<br><br><a href='viewProject.php?pid=$pid'>Return to Project Page</a><br>";
?>
