<?php


class Task
{
    private $id, $name, $workingDaysNeeded, $startDate, $pid, $pTaskID;
    private static $columnList = array("ID", "Name", "WorkingDaysNeeded", "StartDate", "ProjectID", "ParentTask");
    private static $singleQuote = array(NULL, "'",  NULL, "'", NULL, NULL);
    public function __construct($name, $workingDaysNeeded, $startDate, $pid)
    {
        $this->name = $name;
        $this->workingDaysNeeded = $workingDaysNeeded;
        $this->startDate = $startDate;
        $this->pid = $pid;
    }

    public static function getColumnName($i)
    {
        return Task::$columnList[$i];
    }

    public static function getSingleQuote($i)
    {
        return Task::$singleQuote[$i];
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setPTaskID($pTaskID)
    {
        $this->pTaskID = $pTaskID;
    }

    public function getId()
    {
        return $this->id;
    }


    public function getName()
    {
        return $this->name;
    }


    public function getWorkingDaysNeeded()
    {
        return $this->workingDaysNeeded;
    }


    public function getStartDate()
    {
        return $this->startDate;
    }


    public function getPid()
    {
        return $this->pid;
    }


    public function getPTaskID()
    {
        return $this->pTaskID;
    }
}

function getTask($id, $name, $workingDaysNeeded, $startDate, $pid, $pTaskID)
{
    $args = func_get_args();
    $queryString = "SELECT * FROM TASK "; // if all attributes are null just get all attributes, no where here.
    $first = true;
    for ($i = 0; $i < sizeof($args); $i += 1)
    {
        if ($args[$i] !== NULL)
        {
            if ($first) {
                // Found the first condition so add where
                $queryString .= "WHERE ";
                $first = false;
            }
            else{
                // Not first condition, there was a previous condition. needs and
                $queryString .= "AND ";
            }
            // ColumnName = AttributeName
            // Single quotes are optional depending of the attribute needs it or not
            $queryString .= Task::getColumnName($i) . " = "; // ColumnName =
            $queryString .= Task::getSingleQuote($i);
            $queryString .= $args[$i];
            $queryString .= Task::getSingleQuote($i) . " ";

        }
    }

    $conn = openConnection();

    $records = $conn->query($queryString);
    $ret = array();
    while($row = $records->fetch_assoc())
    {
        $t = new Task($row['Name'], $row['WorkingDaysNeeded'], $row['StartDate'], $row['ProjectID']);
        $t->setID($row['ID']);
        $t->setPTaskID($row['ParentTask']);
        array_push($ret, $t);
    }

    closeConnection($conn);
    return $ret;

}

?>