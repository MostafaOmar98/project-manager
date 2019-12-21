<?php

include_once 'Entity.php';
include_once 'db-connection.php';

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

    public function __toString()
    {
        return "".$this->id;
    }
}

function insertTask(Task $t)
{
    // $t should be validated before calling this

    $name = $t->getName();
    $workingDaysNeeded = $t->getWorkingDaysNeeded();
    $startDate = $t->getStartDate();
    $pid = $t->getPid();

    if ($t->getPTaskID() === NULL) {
        $insertQuery = "INSERT INTO Task (Name, WorkingDaysNeeded, StartDate, ProjectID)
        VALUES ('$name', $workingDaysNeeded, '$startDate', $pid)";
    }
    else{
        $pTaskID = $t->getPTaskID();
        $insertQuery = "INSERT INTO Task (Name, WorkingDaysNeeded, StartDate, ProjectID, ParentTask)
        VALUES ('$name', $workingDaysNeeded, '$startDate', $pid, $pTaskID)";
    }

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
            if ($args[$i] != 'NULL') {
                $queryString .= Task::getColumnName($i) . " = "; // ColumnName =
                $queryString .= Task::getSingleQuote($i);
                $queryString .= $args[$i];
                $queryString .= Task::getSingleQuote($i) . " ";
            }
            else{
                $queryString .= Task::getColumnName($i)." IS NULL ";
            }

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

function getTaskFromName($name)
{
    if ($name === NULL)
        return NULL;
    $arr = getTask(NULL, $name, NULL, NULL, NULL, NULL);
    if (sizeof($arr) === 0)
        return NULL;
    return $arr[0];
}

function getAllSubtasks($tid)
{
    if ($tid === NULL)
        return NULL;
    $arr = getTask(NULL, NULL, NULL, NULL, NULL, $tid);
    return $arr;
}

function getTaskFromID($tid)
{
    if ($tid === NULL)
        return NULL;
    $arr = getTask($tid, NULL, NULL, NULL, NULL, NULL);
    if (sizeof($arr) === 0)
        return NULL;
    return $arr[0];
}

function validateNewTaskWorkingDaysNeeded(Project $p, $startDate, $workingDaysNeeded) // needs work, dependancy and summation of all tasks
{
    $dueDate = addDaysToDate($startDate, $workingDaysNeeded);
    if ($dueDate > $p->getDueDate())
        return "Task due date can't be after project due date ";
    return NULL;
}

function validateNewTaskStartDate(Project $p, $startDate)
{
    if ($startDate < $p->getStartDate())
        return "Task start date can't be before project start date ";
    return NULL;
}

function validateNewSubtaskWorkingDays(Task $pTask, $workingDaysNeeded)
{
    $subtasks = getAllSubtasks($pTask->getID());
    $sumDays = 0;
    for ($i = 0; $i < sizeof($subtasks); $i += 1)
        $sumDays += $subtasks[$i]->getWorkingDaysNeeded();
    $sumDays += $workingDaysNeeded;
    if ($sumDays > $pTask->getWorkingDaysNeeded())
        return "Working days needed for subtasks can't be more than working days needed for parent task ";
    return NULL;
}

function validateNewSubtaskStartDate(Task $pTask, $startDate)
{
    if ($startDate < $pTask->getStartDate())
        return "Subtask start date can't be before task start date ";
    return NULL;
}

function getMajorTasks($pid)
{
    return getTask(NULL, NULL, NULL, NULL, $pid, 'NULL');
}

?>