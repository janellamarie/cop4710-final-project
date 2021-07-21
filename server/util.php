<?php

function connect_db()
{
    $serverName = "localhost";
    $userName = "root";
    $password = "";
    $database = "adoptapaw";

    $db = new mysqli($serverName, $userName, $password, $database);

    if ($db->connect_error) 
    {
        die("Connection failed: " . $db->connect_error);
    }
    else
      return $db;
}
?>