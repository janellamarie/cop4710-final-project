<?php

include "util.php";

session_start();

if (isset($_POST["signup-btn"]))
{
    //Establish database connection
    $db = connect_db();

    $first = $_POST["firstname"];
    $last = $_POST["lastname"];
    $m = $_POST["middle"];
    $email = $_POST["email"];
    $pass = $_POST["password"];
    $cpass = $_POST["cpassword"];

    $sql1 = "SELECT * FROM Users WHERE Email = ?";
    $stmt = mysqli_prepare($db, $sql1) or die("Error1: " . mysqli_error($db));
    $stmt->bind_param('s', $email);
    $stmt->execute();

    $result = $stmt->get_result();
    if(!$result)
    {
        die("Error2: " . mysqli_error($db));
    }

    if(mysqli_num_rows($result) != 0)
    {
        $_SESSION["message"] = "Email already registered.";
        header("Location: php/adoptapaw.php");
    }

    if($pass === $cpass)
    {
        $sql2 = $db->prepare("INSERT INTO Users (Email, Password, FirstName, LastName, MiddleInitial) VALUES (?, ?, ?, ?, ?)");
        $sql2->bind_param("sssss", $email, $pass, $first, $last, $m);
        $sql2->execute();

        $_SESSION["message"] = "Successfully Registered";
        header("Location: ../php/adoptapaw.php");

    }
    //passwords do not match
    else
    {
        $_SESSION["message"] = "Passwords must match";
        header("Location: ../php/adoptapaw.php");

    }
}
else
{
    $_SESSION["message"] = "Invalid Access. Login in through our main page.";
     header("Location: ../php/noaccess.php");
     exit;
}
?>