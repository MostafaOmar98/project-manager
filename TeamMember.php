<?php

include_once "db-connection.php";

class TeamMember
{
    private $id, $name, $title;
    private static $columnName = array('ID', 'Name', 'Title');
    private static $singleQuote = array(NULL, "'", "'");

    /**
     * TeamMember constructor.
     * @param $id
     * @param $name
     * @param $title
     */
    public function __construct($id, $name, $title)
    {
        $this->id = $id;
        $this->name = $name;
        $this->title = $title;
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
    $insertQuery = "INSERT INTO teammember (ID, Name, Title) VALUE ($id, '$name', '$title')";
    $conn = openConnection();
    $conn->query($insertQuery);
    closeConnection($conn);
}

function getTeamMember($id, $name, $title)
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
    $records = $conn->query($conn);
    closeConnection($conn);

    $ret = array();
    while($row = $records->fetch_assoc())
    {
        $tm = new TeamMember($row['ID'], $row['Name'], $row['Title']);
        array_push($ret, $tm);
    }
    return $ret;
}

function getTeamMemberWithID($id)
{
    return getTeamMember($id, NULL, NULL);
}

?>