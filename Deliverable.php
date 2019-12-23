<?php
set_time_limit(0);

include_once 'db-connection.php';

class Deliverable
{
    private $id, $name, $description, $pid;

    /**
     * Deliverable constructor.
     * @param $name
     * @param $description
     * @param $pid
     */
    public function __construct($name, $description, $pid)
    {
        $this->name = $name;
        $this->description = $description;
        $this->pid = $pid;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    public function __toString(){
        return "".$this->id." ".$this->name." ".$this->description." ".$this->pid;
    }
}


function insertDeliverable(Deliverable $d)
{
    // d should be validated before calling this function

    $id = $d->getId();
    $name = $d->getName();
    $description = $d->getDescription();
    $pid = $d->getPid();

    $insertQuery = "INSERT INTO deliverable (Name, Description, ProjectID) 
                VALUES ('$name', '$description', $pid)";

    $conn = openConnection();
    $conn->query($insertQuery);
    closeConnection($conn);
}

function getAllDeliverables($pid)
{
    $selectQuery = "SELECT * FROM deliverable WHERE ProjectID = $pid";

    $conn = openConnection();
    $records = $conn->query($selectQuery);
    closeConnection($conn);

    $ret = array();
    while($row = $records->fetch_assoc())
    {
        $d = new Deliverable($row['Name'], $row['Description'], $row['ProjectID']);
        $d->setId($row['ID']);
        array_push($ret, $d);
    }
    return $ret;
}

function getDeliverableWithName($name)
{
    $selectQuery = "SELECT * FROM deliverable WHERE Name = '$name'";

    $conn = openConnection();
    $records = $conn->query($selectQuery);
    closeConnection($conn);

    $ret = array();
    while($row = $records->fetch_assoc())
    {
        $d = new Deliverable($row['Name'], $row['Description'], $row['ProjectID']);
        $d->setId($row['ID']);
        array_push($ret, $d);
    }
    if (sizeof($ret) === 0)
        return NULL;
    return $ret[0];
}

function getDeliverableWithNameInProject($name, $pid)
{
    $selectQuery = "SELECT * FROM deliverable WHERE Name = '$name' AND ProjectID = $pid";

    $conn = openConnection();
    $records = $conn->query($selectQuery);
    closeConnection($conn);

    $ret = array();
    while($row = $records->fetch_assoc())
    {
        $d = new Deliverable($row['Name'], $row['Description'], $row['ProjectID']);
        $d->setId($row['ID']);
        array_push($ret, $d);
    }
    if (sizeof($ret) === 0)
        return NULL;
    return $ret[0];
}

function getDeliverableWithID($did)
{
    $selectQuery = "SELECT * FROM deliverable WHERE ID = $did";

    $conn = openConnection();
    $records = $conn->query($selectQuery);
    closeConnection($conn);

    $ret = array();
    while($row = $records->fetch_assoc())
    {
        $d = new Deliverable($row['Name'], $row['Description'], $row['ProjectID']);
        $d->setId($row['ID']);
        array_push($ret, $d);
    }
    if (sizeof($ret) === 0)
        return NULL;
    return $ret[0];

}

?>