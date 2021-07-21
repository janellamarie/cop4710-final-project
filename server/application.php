<?php 
include 'util.php';

if (isset($_POST["application-submit"]))
{
    //*initialize session
    session_start();

    $user = $_SESSION["username"];
    $pet = $_POST["PetName"];

    //query definitions
    $sql1 = "SELECT * FROM animals WHERE Name = ?";

    $sql2 = "SELECT ApplicantID FROM users NATURAL JOIN applicants WHERE email = ?";

    $application_submission = "INSERT INTO Application (ApplicantID, AnimalID, HomeType, Employed, LandlordApproval, Date) 
                       VALUES (?, ?, ?, ?, ?, ?)";

    //establish and check connection 
    $db = connect_db();

    //get petID
    $stmt1 = mysqli_prepare($db, $sq11);
    $stmt1->bind_param("s", $_POST["PetName"]);
    $stmt1->execute();
    $result1 = $stmt->get_result();
    if (!$result1)
        die("Error: " . mysqli_error($db));

    $row1 = mysqli_fetch_assoc($result1);
    $petID = $row1["PetID"];

    //get applicant ID
    $stmt2 = mysqli_prepare($db, $sql2);
    $stmt2->bind_param("s", $user);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    if(!$result2)
        die("Error: " . mysqli_error($db));
    
    $row2 = mysqli_fetch_assoc($result2);
    $applicantID = $row2["ApplicantID"];


    // Get form values from form
    $homeType = $_POST['HomeType'];
    $isEmployed = $_POST["Employed"];
    $landlordApproval = $_POST['LandlordApproval'];
    $date = $_POST["Date"];

    $stmt3 = mysqli_prepare($db, $application_submission);
    $stmt3->bind_param("iissss", $applicantID, $petID, $homeType, $isEmployed, $landlordApproval, $date);
    $stmt->execute();
    $result3 = $stmt->get_result();
    if(!$result3)
        die("Errors: " . mysqli_error($db));
}
//redirect to mainpage
else
{
    $_SESSION["message"] = "Please login to submit applications";
    header("Location: ../php/adoptapaw.php");
    exit;
}

?>