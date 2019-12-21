<?php


class Task extends Entity
{
    private $id, $name, $workingDaysNeeded, $startDate, $pid, $pTaskID;
    private static $columnList = array("ID", "Name", "WorkingDaysNeeded", "StartDate", "ProjectID", "ParentTask");
    private static $singleQuote = array(NULL, "'",  NULL, "'", NULL, NULL);
    public function __construct($name, $workingDaysNeeded, $startDate, $pid)
    {
        $error = "";
        $id = NULL;
        $pTaskID = NULL;
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

function insertTask(Task $t)
{
    // $t should be validated before calling this

    $name = $t->getName();
    $workingDaysNeeded = $t->getWorkingDaysNeeded();
    $startDate = $t->getStartDate();
    $pid = $t->getPid();

    $insertQuery = "INSERT INTO Task (Name, WorkingDaysNeeded, StartDate, ProjectID)
        VALUES ('$name', $workingDaysNeeded, '$startDate', $pid)";

    $conn = openConnection();
    $conn->query($insertQuery);
    closeConnection($conn);

}

function getTask($id, $name, $workingDaysNeeded, $startDate, $pid, $pTaskID)
{
    /*
     * @param values of attributes for columns. NULL if this attribute is not added to WHERE clause
     * Returns array of tasks
     */
    $args = func_get_args();
    $queryString = "SELECT * FROM task "; // if all attributes are null just get all attributes, no where here.
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
    closeConnection($conn);

    $ret = array();
    while($row = $records->fetch_assoc())
    {
        $t = new Task($row['Name'], $row['WorkingDaysNeeded'], $row['StartDate'], $row['ProjectID']);
        $t->setID($row['ID']);
        $t->setPTaskID($row['ParentTask']);
        array_push($ret, $t);
    }

    return $ret;
}

function getTaskWithName($name)
{
    $arr = getTask(NULL, $name, NULL, NULL, NULL, NULL);
    if (sizeof($arr) === 0)
        return NULL;
    return $arr[0];
}

function getAllSubtasks($tid)
{
    $arr = getTask(NULL, NULL, NULL, NULL, NULL, $tid);
    return $arr;
}

?>