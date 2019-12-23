<?php
set_time_limit(0);

include_once 'db-connection.php';
class Dependency
{
    private $dependent, $dependency;

    /**
     * Dependency constructor.
     * @param $dependent
     * @param $dependency
     */
    public function __construct($dependent, $dependency)
    {
        $this->dependent = $dependent;
        $this->dependency = $dependency;
    }

    /**
     * @return mixed
     */
    public function getDependent()
    {
        return $this->dependent;
    }

    /**
     * @return mixed
     */
    public function getDependency()
    {
        return $this->dependency;
    }

    public function getDependentId()
    {
        return $this->getDependent()->getId();
    }

    public function getDependencyId()
    {
        return $this->getDependency()->getId();
    }
}

function insertDependency(Dependency $d)
{
    $dependentID = $d->getDependentId();
    $dependencyID = $d->getDependencyId();

    $q = "INSERT INTO dependson (DependentID, DependencyID) VALUES ($dependentID, $dependencyID)";

    $conn = openConnection();
    $conn->query($q);
    closeConnection($conn);
}

function insertDependencies($dependent, $depTasks)
{
    for ($i = 0; $i < sizeof($depTasks); $i += 1)
    {
        $dependency = $depTasks[$i];
        $d = new Dependency($dependent, $dependency);
        insertDependency($d);
    }
}

function getAllDependencyTasks(Task $t)
{
    $tid = $t->getId();
    $q = "SELECT DependencyID FROM dependson where DependentID = $tid";

    $conn = openConnection();
    $records = $conn->query($q);
    closeConnection($conn);
    $ret = array();
    while($row = $records->fetch_assoc())
    {
        $tid = $row['DependencyID'];
        array_push($ret, getTaskFromID($tid));
    }
    return $ret;
}

function getAllDependentTasks(Task $t)
{
    $tid = $t->getId();
    $q = "SELECT DependentID FROM dependson where DependencyID = $tid";

    $conn = openConnection();
    $records = $conn->query($q);
    closeConnection($conn);
    $ret = array();
    while($row = $records->fetch_assoc())
    {
        $tid = $row['DependentID'];
        array_push($ret, getTaskFromID($tid));
    }
    return $ret;
}