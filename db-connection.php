<?php
set_time_limit(0);
$counter = 0;

function openConnection()
{
    $localhost = "127.0.0.1";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "projectmanager";
    $dbPort = 3306;

    $conn = new mysqli($localhost, $dbUsername, $dbPassword, $dbName, $dbPort);

    if ($conn->connect_error)
        die("Connection failed: " . $conn->connect_error);

    return $conn;
}

function closeConnection($conn)
{
    $conn->close();
}


?>
