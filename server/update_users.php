<?php

if ($_SERVER['REQUEST_METHOD']=='POST') {
  $input = filter_input_array(INPUT_POST);
} else {
  $input = filter_input_array(INPUT_GET);
}

$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "adoptapaw"; // change to db name in local server

// create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($input['action'] == 'edit') {
    $sql = "UPDATE users SET Email='" . $input['Email'] . "', Password='" . $input['Password'] . "', FirstName='" . $input['FirstName'] . "', LastName='" . $input['LastName'] . "', MiddleInitial='" . $input['MiddleInitial'] . "' WHERE UserID='" . $input['UserID'] . "';";
    $conn->query($sql);
} else if ($input['action'] == 'delete') {
    $sql = "DELETE FROM users WHERE UserID='" . $input['UserID'] . "'";
    $conn->query($sql);
}

mysqli_close($conn);

echo json_encode($input);
?>
