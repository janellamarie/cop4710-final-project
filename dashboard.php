<?php
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
?>

<!DOCTYPE html>
<html>
    <head>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="css/assets.css"/>
        <link rel="stylesheet" href="css/dashboard.css"/>


        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Viga&display=swap" rel="stylesheet">

        <script src="//code.jquery.com/jquery.min.js"></script>
        <script src="js/jquery.tabledit.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript">

            function openTab(evt, tabName)
            {
                var i, tabcontent, tablinks;

                // Hide all elements of class="tabcontent"
                tabcontent = document.getElementsByClassName("tabcontent");
                for (i = 0; i < tabcontent.length; i++)
                {
                    tabcontent[i].style.display = "none";
                }

                // Get all elements with class="tablinks", remove class "active"
                tablinks = document.getElementsByClassName("tablinks");
                for (i = 0; i < tablinks.length; i++)
                {
                    tablinks[i].className = tablinks[i].className.replace(" active", "");
                }

                // Show current tab, add an "active" class to button that opened the tab
                document.getElementById(tabName).style.display = "inline";
                evt.currentTarget.className += " active";
            };
        </script>
    </head>

    <body>
        <div class="content">
            <div class="panel">
                <h1><span style="color: white">Adopta</span><span style="color:#490178">Paw</span></h1>
                <div class="img-container"></div>
                <div class="tab">
                    <button class="tablinks" onclick="openTab(event, 'animals')">
                        <img src="../img/paw.png">
                        Animals
                    </button>
                </div>


                <div class="tab">
                    <button class="tablinks" onclick="openTab(event, 'applications')">
                        <img src="../img/application.png">
                        Applications</button>
                </div>
                <div class="tab">
                    <button class="tablinks" onclick="openTab(event, 'users')">
                        <img src="../img/person.png">
                        Users
                    </button>
                </div>
                <div class="tab">
                    <button class="tablinks" onclick="openTab(event, 'settings')">
                        <img src="../img/settings.png">
                        Settings</button>
                </div>
            </div>

            <div class="work-space">
                <div class="top-bar">
                </div>

                <div id="animals" class="tabcontent">
                    <div class="scroll">
                        <table class="btable" id="animal-table">
                            <tr>
                                <!-- code if admin display -->
                                <th>AnimalID</th>
                                <th>Name</th>
                                <th>Breed</th>
                                <th>Species</th>
                                <th>Height</th>
                                <th>Weight</th>
                                <th>DOB</th>
                                <th>Arrival_Date</th>
                                <th>Color</th>
                                <th>Available</th>
                                <th>ImagePath</th>
                                <th class="tabledit-toolbar-column"></th>
                            </tr>

                            <?php        

                            // query to executre
                            $sql = "SELECT * FROM animals";

                            // run query
                            $result = $conn->query($sql);

                            // check if query has results
                            if($result !== false && $result->num_rows > 0) {
                                // display results of query
                                while($row = $result->fetch_assoc()) {
                                    echo '<tr>' .
                                        '<td class="tabledit-view-mode">' . $row["AnimalID"] . '</td>' .
                                        '<td class="tabledit-view-mode">' . $row["Name"] . '</td>'  .
                                        '<td class="tabledit-view-mode">' . $row["Breed"] . '</td>'  .
                                        '<td class="tabledit-view-mode">' . $row["Species"] . '</td>'  .
                                        '<td class="tabledit-view-mode">' . $row["Height"] . '</td>'  .
                                        '<td class="tabledit-view-mode">' . $row["Weight"] . '</td>' .
                                        '<td class="tabledit-view-mode">' . $row["DOB"] . '</td>'  .
                                        '<td class="tabledit-view-mode">' . $row["Arrival_Date"] . '</td>'  .
                                        '<td class="tabledit-view-mode">' . $row["Color"] . '</td>'  .
                                        '<td class="tabledit-view-mode">' . $row["Available"] . '</td>' .
                                        '<td class="tabledit-view-mode">' . $row["ImagePath"] . '</td>' .
                                        '<td>' . 
                                        '<div class="tabledit-toolbar btn-toolbar">' .
                                        '<div class="btn-group btn-group-sm">' .
                                        '<button type="button" class="tabledit-edit-button btn btn-sm btn-primary">' .
                                        '<span class="glyphicon glyphicon-pencil">' .
                                        '</span> EDIT' .
                                        '</button>' .
                                        '</div>' .
                                        '</div>' .
                                        '</td>';
                                }
                            } 

                            ?>

                        </table>

                        <script type="text/javascript" language="javascript">

                            $(document).ready(function() {
                                $('#animal-table').Tabledit({
                                    url: 'dashboard.php',
                                    editButton: true,
                                    deleteButton: false,
                                    autoFocus: false,
                                    columns: {
                                        identifier: [0, 'AnimalID'],                    
                                        editable: [[1, 'Name'], [2, 'Breed'], [3, 'Species'], [4, 'Height'], [5, 'Weight'], [6,'DOB'],[7, 'Arrival_Date'], [8, 'Color'], [9,' ImagePath']]
                                    },
                                    buttons: {
                                        edit: {
                                            class: 'btn btn-sm btn-primary',
                                            html: '<span class="glyphicon glyphicon-pencil"></span> &nbsp EDIT',
                                            action: 'edit'
                                        }
                                    },
                                });
                            });

                        </script>
                    </div>
                </div>

                <div id="applications" class="tabcontent"> <div class="scroll">
                    <table class="btable" id="applications-table">
                        <tr>
                            <!-- code if admin display -->
                            <th>ApplicationID</th>
                            <th>ApplicantID</th>
                            <th>AnimalID</th>
                            <th>HomeType</th>
                            <th>Employed</th>
                            <th>LandlordApproval</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="tabledit-toolbar-column"></th>
                        </tr>

                        <?php        

                        // query to executre
                        $sql = "SELECT * FROM applications";

                        // run query
                        $result = $conn->query($sql);

                        // check if query has results
                        if($result !== false && $result->num_rows > 0) {
                            // display results of query
                            while($row = $result->fetch_assoc()) {
                                echo '<tr>' .
                                    '<td class="tabledit-view-mode">' . $row["ApplicationID"] . '</td>' .
                                    '<td class="tabledit-view-mode">' . $row["ApplicantID"] . '</td>'  .
                                    '<td class="tabledit-view-mode">' . $row["AnimalID"] . '</td>'  .
                                    '<td class="tabledit-view-mode">' . $row["HomeType"] . '</td>'  .
                                    '<td class="tabledit-view-mode">' . $row["Employed"] . '</td>'  .
                                    '<td class="tabledit-view-mode">' . $row["LandlordApproval"] . '</td>' .
                                    '<td class="tabledit-view-mode">' . $row["Date"] . '</td>'  .
                                    '<td>' . 
                                    '<div class="tabledit-toolbar btn-toolbar">' .
                                    '<div class="btn-group btn-group-sm">' .
                                    '<button type="button" class="tabledit-edit-button btn btn-sm btn-primary">' .
                                    '<span class="glyphicon glyphicon-pencil">' .
                                    '</span> EDIT' .
                                    '</button>' .
                                    '</div>' .
                                    '</div>' .
                                    '</td>';
                            }
                        } 

                        ?>

                    </table>

                    <script type="text/javascript" language="javascript">
                        // insert editable script here

                    </script>
                    </div> 
                </div>

                <div id="users" class="tabcontent"> 
                    <table class="btable" id="users-table">
                        <tr>
                            <!-- code if admin display -->
                            <th>UserID</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>FirstName</th>
                            <th>LastName</th>
                            <th>MiddleInitial</th>
                            <th class="tabledit-toolbar-column"></th>
                        </tr>

                        <?php        

                        // query to executre
                        $sql = "SELECT * FROM users";

                        // run query
                        $result = $conn->query($sql);

                        // check if query has results
                        if($result !== false && $result->num_rows > 0) {
                            // display results of query
                            while($row = $result->fetch_assoc()) {
                                echo '<tr>' .
                                    '<td class="tabledit-view-mode">' . $row["UserID"] . '</td>' .
                                    '<td class="tabledit-view-mode">' . $row["Email"] . '</td>'  .
                                    '<td class="tabledit-view-mode">' . $row["Password"] . '</td>'  .
                                    '<td class="tabledit-view-mode">' . $row["FirstName"] . '</td>'  .
                                    '<td class="tabledit-view-mode">' . $row["LastName"] . '</td>'  .
                                    '<td class="tabledit-view-mode">' . $row["MiddleInitial"] . '</td>' .
                                    '<td>' . 
                                    '<div class="tabledit-toolbar btn-toolbar">' .
                                    '<div class="btn-group btn-group-sm">' .
                                    '<button type="button" class="tabledit-edit-button btn btn-sm btn-primary">' .
                                    '<span class="glyphicon glyphicon-pencil">' .
                                    '</span> EDIT' .
                                    '</button>' .
                                    '</div>' .
                                    '</div>' .
                                    '</td>';
                            }
                        } 

                        ?>

                    </table>
                    <script>
                        // insert editable script    
                    </script>
                </div>

                <div id="settings" class="tabcontent"> settings </div>
            </div
        </div>

    </body>
</html>