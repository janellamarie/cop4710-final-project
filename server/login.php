<?php

include "util.php";

session_start();

if (isset($_POST["login-btn"]))
{
    //Establish database connection
    $db = connect_db();

    //get entered login info
    $user = $_POST["email"];
    $pass = $_POST["password"];


    //initialize queries
    $sql1 = "SELECT * From Users WHERE Email = ?";

    $stmt = mysqli_prepare($db, $sql1) or die("Error: " . mysqli_error($db));
    $stmt->bind_param("s", $user);
    $stmt->execute();

    $result = $stmt->get_result();

    if(!$result)
    {
        die("Error: " . mysqli_error($db));
    }

    if(mysqli_num_rows($result) == 0)
    {
        $_SESSION["message"] = "Email Not Registered";
        header("Location: ../php/adoptapaw.php");
        exit;
    }

    $row = mysqli_fetch_assoc($result);

    $check_user = $row["Email"];
    $check_pass = $row["Password"];
    $id = $row["UserID"];

    if($user === $check_user && $check_pass === $password)
    {
        $_SESSION["username"] = $user;
        $_SESSION["success"] = "logged in";
    }

    $sql2 = "SELECT * FROM Managers WHERE UserID = ?";
    $stmt2 = mysqli_prepare($db, $sql2) or die("Error: " . mysqli_error($db));
    $stmt2->bind_param("i", $id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    $sql3 = "SELECT * FROM Admins WHERE UserID = ?";
    $stmt3 = mysqli_prepare($db, $sql3) or die("Error: " . mysqli_error($db));
    $stmt3->bind_param("i", $id);
    $stmt3->execute();

    $result3 = $stmt3->get_result();

    if (!$result2)
    {
        die("Error: " . mysqli_error($db));
    }

    if (!$result3)
    {
        die("Error: " . mysqli_error($db));
    }

    $row2 = mysqli_fetch_assoc($result2);
    $row3 = mysqli_fetch_assoc($result3);

    //check if regular user
    if(mysqli_num_rows($result2) == 0 && mysqli_num_rows($result3) == 0)
    {
        header("Location: ../php/adoptapaw.php");
        exit;
    }

    //check if manager or admin
    if (mysqli_num_rows($result2) != 0)
    {
        $_SESSION["user-type"] == "manager";
        header("Location: ../php/dashboard.php");
    }

    if(mysqli_num_rows($result3) != 0)
    {
        $_SESSION["user-type"] == "admin";
        header("Location: ../php/admin-dashboard.php");
    }

}
else
{
    $_SESSION["message"] = "Invalid Access. Login in through our main page.";
     header("Location: ../php/noacess.php");
     exit;
}
?>