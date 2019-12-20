<?php

function openConnection()
{
    $localhost = "localhost";
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
