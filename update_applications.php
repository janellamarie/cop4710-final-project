<?php

if ($_SERVER['REQUEST_METHOD']=='POST') {
    $input = filter_input_array(INPUT_POST);
} else {
    $input = filter_input_array(INPUT_GET);
}

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
    // update applications table
    $sql = "UPDATE applications SET ApplicantID='" . $input['ApplicantID'] . 
        "', AnimalID='" . $input['AnimalID'] . 
        "', HomeType='" . $input['HomeType'] . 
        "', Employed='" . $input['Employed'] . 
        "', LandlordApproval='" . $input['LandlordApproval'] . 
        "', Date='" . $input['Date'] .  
        "', Status='" . $input['Status'] .
        "' WHERE ApplicationID='" . $input['ApplicationID'] . "';";
    $conn->query($sql);

    // update Adopters and Animals tables
    if($input['Status'] == 'APPROVED') {
        // insert approved ApplicantID into Adopters
        $sql = "INSERT INTO adopters(ApplicantID) VALUES ('" . $input['ApplicantID'] . "');";
        $conn->query($sql);
        
        // update Animal availability
        $sql = "UPDATE animals SET Available='NOT_AVAILABLE' WHERE AnimalID=" . $input['AnimalID'] . ";";
        $conn->query($sql);
    }
} else if ($input['action'] == 'delete') {
    $sql = "DELETE FROM applications WHERE ApplicationID='" . $input['ApplicationID'] . "'";
    $conn->query($sql);
}

mysqli_close($conn);

echo json_encode($input);
?>
