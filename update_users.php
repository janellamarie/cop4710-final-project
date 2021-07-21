<?php

$input = filter_input_array(INPUT_POST);

$servername = "localhost:3306";
$username = "root";
$password = "";
$dbname = "test"; // change to db name in local server

// create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($input['action'] == 'edit') {
    $sql = "UPDATE users SET Email='" . $input['Email'] . "', Password='" . $input['Password'] . "', FirstName='" . $input['FirstName'] . "', LastName='" . $input['LastName'] . "', MiddleInitial='" . $input['MiddleInitial'] . "' WHERE id='" . $input['id'] . "'";
    echo $sql;
    $conn->query($sql);
}

mysqli_close($conn);

echo json_encode($input);
?>
