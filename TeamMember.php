<?php
set_time_limit(0);

include_once "db-connection.php";

class TeamMember
{
    private $id, $name, $title, $pid;
    private static $columnName = array('ID', 'Name', 'Title', 'ProjectID');
    private static $singleQuote = array(NULL, "'", "'", NULL);

    /**
     * TeamMember constructor.
     * @param $id
     * @param $name
     * @param $title
     */
    public function __construct($id, $name, $title, $pid)
    {
        $this->id = $id;
        $this->name = $name;
        $this->title = $title;
        $this->pid = $pid;
    }

    /**
     * @return mixed
     */
    public function getPid()
    {
        return $this->pid;
    }

    public static function getColumnName($i)
    {
        return TeamMember::$columnName[$i];
    }

    public static function getSingleQuote($i)
    {
        return TeamMember::$singleQuote[$i];
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
    public function getTitle()
    {
        return $this->title;
    }

}

function insertTeamMember(TeamMember $tm)
{
    // $tm should be validated before calling this
    $id = $tm->getId();
    $name = $tm->getName();
    $title = $tm->getTitle();
    $pid = $tm->getPid();
    $insertQuery = "INSERT INTO teammember (ID, Name, Title, ProjectID) VALUE ($id, '$name', '$title', $pid)";
    $conn = openConnection();
    $conn->query($insertQuery);
    closeConnection($conn);
}

function getTeamMember($id, $name, $title, $pid)
{
    $q = "SELECT * FROM teammember ";
    $first = true;
    $args = func_get_args();
    for ($i = 0; $i < sizeof($args); $i += 1)
    {
        $att = $args[$i];
        if ($att !== NULL)
        {
            if ($first)
            {
                $q .= "WHERE ";
                $first = false;
            }
            else
                $q.= "AND ";
            $q .= TeamMember::getColumnName($i)." = ";
            $q .= TeamMember::getSingleQuote($i);
            $q .= $att;
            $q .= TeamMember::getSingleQuote($i)." ";
        }
    }

    $conn = openConnection();
    $records = $conn->query($q);
    closeConnection($conn);

    $ret = array();
    while($row = $records->fetch_assoc())
    {
        $tm = new TeamMember($row['ID'], $row['Name'], $row['Title'], $row['ProjectID']);
        array_push($ret, $tm);
    }
    return $ret;
}


function getTeamMemberWithPid($pid)
{
    return getTeamMember(NULL, NULL, NULL, $pid);
}

function getTeamMemberWithID($tmid)
{
    $arr = getTeamMember($tmid, NULL, NULL, NULL);
    if (sizeof($arr) === 0)
        return NULL;
    return $arr[0];
}

function getTeamMemberWithIdInProject($tmid, $pid){
    $arr = getTeamMember($tmid, NULL, NULL, $pid);
    if (sizeof($arr) === 0)
        return NULL;
    return $arr[0];
}

?>