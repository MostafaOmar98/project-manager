<?php
set_time_limit(0);

include_once 'db-connection.php';
include_once 'Project.php';
include_once 'Task.php';

class CompletedTask
{
    private $tid, $startDate, $endDate;

    /**
     * CompletedTask constructor.
     * @param $tid
     * @param $startDate
     * @param $endDate
     */
    public function __construct($tid, $startDate, $endDate)
    {
        $this->tid = $tid;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * @return mixed
     */
    public function getTid()
    {
        return $this->tid;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }
}

function insertCompletedTask(CompletedTask $c)
{
    $tid = $c->getTid();
    $startDate = $c->getStartDate();
    $endDate = $c->getEndDate();

    $q = "INSERT INTO completedtask (TaskID, StartDate, EndDate) VALUES ($tid, '$startDate', '$endDate')";

    $conn = openConnection();
    $conn->query($q);
    closeConnection($conn);
}

function getCompletedTaskWithTid($tid)
{
    $q = "SELECT * FROM completedtask where TaskID = $tid";


    $conn = openConnection();
    $records = $conn->query($q);
    closeConnection($conn);

    $ret = array();
    while($row = $records->fetch_assoc())
    {
        $c = new CompletedTask($tid, $row['StartDate'], $row['EndDate']);
        array_push($ret, $c);
    }

    return $ret;
}
