<?php

include_once 'Utility.php';
include_once 'Task.php';
include_once 'Dependency.php';
include_once 'TeamMember.php';
class WorksOn
{
    private $TeamMember, $task, $hours;

    /**
     * WorksOn constructor.
     * @param $TeamMember
     * @param $task
     * @param $hours
     */
    public function __construct($TeamMember, $task, $hours)
    {
        $this->TeamMember = $TeamMember;
        $this->task = $task;
        $this->hours = $hours;
    }

    /**
     * @return mixed
     */
    public function getTeamMember()
    {
        return $this->TeamMember;
    }

    /**
     * @return mixed
     */
    public function getTask()
    {
        return $this->task;
    }

    /**
     * @return mixed
     */
    public function getHours()
    {
        return $this->hours;
    }

    public function getTeamMemberID()
    {
        return $this->TeamMember->getId();
    }

    public function getTaskId()
    {
        return $this->task->getId();
    }

    public function setTask($t)
    {
        $this->task = $t;
    }

}

function insertWorksOn(WorksOn $worksOn)
{
    $tmid = $worksOn->getTeamMemberID();
    $tid = $worksOn->getTaskId();
    $hours = $worksOn->getHours();

    $q = "INSERT INTO workson (TeamMemberID, TaskID, CommittedWorkingHours) VALUES($tmid, $tid, $hours)";
    $conn = openConnection();
    $conn->query($q);
    closeConnection($conn);
}

function validateWorksOn($team, $taskWorkingDays, &$teamError)
{
    $worksOnArr = explode(",", $team);
    $ret = array();
    for ($i = 0; $i < sizeof($worksOnArr); $i += 1)
    {
        $pairString = trim($worksOnArr[$i]);
        $pair = explode("-", $pairString);
        if (sizeof($pair) != 2){
            $teamError .= "Invalid Format. ";
            return NULL;
        }
        $tmid = trim($pair[0]);
        $hours = trim($pair[1]);
        $teamMember = getTeamMemberWithID($tmid);
        if ($teamMember === NULL) {
            $teamError .= "Team Member with ID $tmid does not exist. ";
            return NULL;
        }


        $teamError .= checkNumericLimits($hours, 1, $taskWorkingDays * 8);
        if (!empty($teamError))
            return NULL;
        $w = new WorksOn($teamMember, NULL, $hours); // NULL placeholder for now
        array_push($ret, $w);
    }
    return $ret;
}

function insertWorksOnArr($worksOnArr, $task)
{
    for ($i = 0; $i < sizeof($worksOnArr); $i += 1)
    {
        $w = $worksOnArr[$i];
        $w->setTask($task);
        insertWorksOn($w);
    }
}

?>