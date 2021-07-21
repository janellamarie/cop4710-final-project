<?php
session_start();
echo $_SESSION["user-type"];
if($_SESSION["user-type"] == "manager")
    echo "true";
?>