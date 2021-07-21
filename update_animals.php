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
    $sql = "UPDATE animals SET Name='" . $input['Name'] . 
            "', Breed='" . $input['Breed'] . 
            "', Species='" . $input['Species'] . 
            "', Height='" . $input['Height'] . 
            "', Weight='" . $input['Weight'] . 
            "', DOB='" . $input['DOB'] .  
            "', Arrival_Date='" . $input['Arrival_Date'] . 
            "', Available='" . $input['Available'] . 
            "', Color='" . $input['Color'] . 
            "', ImagePath='" .$input['ImagePath'] . 
            "' WHERE AnimalID='" . $input['AnimalID'] . "';";
    $conn->query($sql);
} else if ($input['action'] == 'delete') {
    $sql = "DELETE FROM animals WHERE AnimalID='" . $input['AnimalID'] . "'";
    $conn->query($sql);
}

mysqli_close($conn);

echo json_encode($input);
?>
