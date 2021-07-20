<?php 
session_start();

if(isset($_SESSION["message"]))
{
    echo'<script type="text/javascript">alert("' . $_SESSION['message'] . '");</script>';
    unset($_SESSION["message"]);
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
echo '<script>console.log("Connected to database")</script>';
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/assets.css"/>
        <script type="text/javascript">

            function openSidebar()
            {
                var x = document.getElementById("sidebar");
                var y = document.getElementById("grid");

                if (x.style.display === "none")
                {
                    x.style.display = "block";
                    y.style.gridTemplateColumns = "auto auto auto auto auto";
                }
                else    
                    x.style.display = "none";
            }        
        </script>
    </head>

    <body>
        <div class="header">
            <div class="top-container">
                <div class="nav-links">
                    <a href="">About</a>
                    <a href="">Contact</a>
                    <a href="">Donate</a>
                    <a href="">Designers</a>
                </div>

                <div class="nav-links">
                    <button class="btn">Login</button>
                    <button class="btn">Sign Up</button>
                </div>
            </div>

            <div class="bottom-container">
                <div class="nav-links">
                    <button class="menu-btn" onclick="openSidebar()"></button>  
                </div>

                <div class="search-container">
                    <form method="post" id="search_animal">
                        <input type="text" placeholder="Search" name="search">
                        <button class="search-btn" type="submit"><img src="../img/search.png"/></button> 
                    </form>
                </div>

            </div>
        </div>

        <div class="content">
            <div class="sidebar" id="sidebar">
                <div class="custom-select">
                    <form method="post" id="species_breed_filter">
                        <h1>Species</h1>
                        <select class="select-css" name="species" id="select_species">
                            <?php 
                            $sql = "SELECT DISTINCT Species FROM animals;";
                            echo '<option value="ALL"> ALL </option>';
                            $result = $conn->query($sql);
                            while($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row["Species"] . '">' . $row["Species"] . '</option>';
                            }
                            ?>
                        </select>

                        <h1>Breed</h1>
                        <!-- edit so that the select changes depending on the Breed -->
                        <select class="select-css" name="breed">
                            <?php 
                            $species = $_POST['select_species'];
                            $sql = "SELECT DISTINCT Breed FROM animals;";
                            echo '<option value="ALL"> ALL </option>';
                            $result = $conn->query($sql, $row);
                            while($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row["Breed"] . '" id="select_breed">' . $row["Breed"] . '</option>';
                            }

                            ?>
                        </select>

                        <h1>Age</h1>
                        <div class="age-filter-container">
                            <ul>
                                <li>
                                    <input type="radio" name="age" value="TIMESTAMPDIFF(YEAR, DOB, CURDATE()) <= '5 years'">
                                    <label>Ages 0-5</label>
                                </li>
                                <li>
                                    <input type="radio" name="age" value="TIMESTAMPDIFF(YEAR, DOB, CURDATE()) > '5 years' AND TIMESTAMPDIFF(YEAR, DOB, CURDATE()) <= '10 years'">
                                    <label>Ages 5-10</label>
                                </li>
                                <li>
                                    <input type="radio" name="age" value="TIMESTAMPDIFF(YEAR, DOB, CURDATE()) > '10 years'">
                                    <label>Ages 10+</label>
                                </li>

                            </ul>
                        </div>

                        <div class="submit-button-container">
                            <button class="submit-button" type="submit" form="species_breed_filter" value="Submit">Submit</button>
                        </div>

                    </form>
                </div>
            </div>

            <div id="grid" class="grid">
                <?php
                // if search is used
                if(isset($_POST['search'])) {
                    $sql = "SELECT AnimalID, Name, Species, TIMESTAMPDIFF(YEAR, DOB, CURDATE()) AS Age, ImagePath FROM Animals WHERE Name LIKE '%" . $_POST['search'] . "%' OR Breed LIKE '%" . $_POST['search'] . "%' OR Species LIKE '%". $_POST['search'] ."%'";
                // if the user uses the filters    
                } else if(isset($_POST['species'], $_POST['breed'])) {
                    $species = $_POST['species'];
                    $breed = $_POST['breed'];
                    if($species == "ALL" && $breed == "ALL") {
                        $sql = "SELECT AnimalID, Name, Species, TIMESTAMPDIFF(YEAR, DOB, CURDATE()) AS Age, ImagePath FROM animals";
                    } else if($species != "ALL"){
                        $species = $_POST['species'];
                        $sql = "SELECT Name, Species, TIMESTAMPDIFF(YEAR, DOB, CURDATE()) AS Age, ImagePath FROM animals WHERE Species LIKE '$species'";
                    } else if($breed != "ALL") {
                        $breed = $_POST['breed'];
                        $sql = "SELECT AnimalID, Name, Species, TIMESTAMPDIFF(YEAR, DOB, CURDATE()) AS Age, ImagePath FROM animals WHERE Breed LIKE '$breed'";
                    }

                    if(isset($_POST['age'])) {
                        if($species == "ALL" && $breed == "ALL") {
                            $age = $_POST['age'];
                            $sql .= " WHERE " . $age . ";";
                        } else {
                            $age = $_POST['age'];
                            $sql .= ' AND ' . $age;
                        }
                    }

                    $sql .= ";";

                } else {
                    $sql = "SELECT AnimalID, Name, Species, TIMESTAMPDIFF(YEAR, DOB, CURDATE()) AS Age, ImagePath FROM animals;";
                }

                $result = $conn->query($sql);

                if($result !== false && $result->num_rows > 0) {
                    // display results of query
                    while($row = $result->fetch_assoc()) {
                        echo 
                            '<div class="animal-box">' .
                                '<img src="' . $row["ImagePath"] . '"/>' .
                                '<form method="post" class="animal-data-container" name="AnimalID" value="' . $row["AnimalID"] . '">' .
                                    '<ul class="animal-data">' .
                                        '<li><h2>' . $row["Name"]  . '</h2></li>' .
                                        '<li>' . $row["Species"] . '</li>' .
                                        '<li>' . $row["Age"] . ' years old </li>' .
                                    '</ul>'.
                                    '<button type="submit" class="adopt-button">Adopt</button>' .
                                '</form>' .
                            '</div>';
                    }
                } else {
                    echo '<div class="search-error"><h1> No pets found! </h1></div>';
                }

                $_POST = array();
                ?>
            </div>

        </div>
    </body>
</html>