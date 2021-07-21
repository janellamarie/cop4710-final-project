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

        <script src="js/jquery-3.6.0.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="js/jquery.tabledit.js"></script>
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

            $(document).ready(function(){
                $('#animals-table').Tabledit({
                    url: 'update_animals.php',
                    editButton: true,
                    deleteButton: false,
                    saveButton: true,
                    autoFocus: false,
                    buttons: {
                        edit: {
                            class: 'btn btn-sm btn-primary',
                            html: '<span class="glyphicon glyphicon-pencil"></span> &nbsp EDIT',
                            action: 'edit'
                        }
                    },
                    columns: {
                        identifier: [0, 'AnimalID'],                    
                        editable: [[1, 'Name'], [2, 'Breed'], [3, 'Species'], [4, 'Height'], [5, 'Weight'], [6,'DOB'],[7, 'Arrival_Date'], [8, 'Color'], [9, 'Available'], [10, 'ImagePath']]
                    }                    
                });


                $('#applications-table').Tabledit({
                    editButton: true,
                    deleteButton: false,
                    saveButton: true,
                    autoFocus: false,
                    buttons: {
                        edit: {
                            class: 'btn btn-sm btn-primary',
                            html: '<span class="glyphicon glyphicon-pencil"></span> &nbsp EDIT',
                            action: 'edit'
                        }
                    },
                    columns: {
                        identifier: [0, 'ApplicationID'],                    
                        editable: [[1, 'ApplicationID'], [2, 'AnimalID'], [3, 'HomeType'], [4, 'Employed'], [5, 'LandlordApproval'], [6,'Date'], [7, 'Status']]
                    }                    
                });

                $('#users-table').Tabledit({
                    url: 'update_users.php',
                    editButton: true,
                    deleteButton: false,
                    saveButton: true,
                    autoFocus: false,
                    buttons: {
                        edit: {
                            class: 'btn btn-sm btn-primary',
                            html: '<span class="glyphicon glyphicon-pencil"></span> &nbsp EDIT',
                            action: 'edit'
                        }
                    },
                    columns: {
                        identifier: [0, 'UserID'],
                        editable: [[1, 'Email'], [2, 'Password'], [3, 'FirstName'], [4, 'LastName'], [5, 'MiddleInitial']]
                    }
                });
            });
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

                <!-- start of Animals table display -->
                <div id="animals" class="tabcontent">
                    <div class="scroll">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="animals-table">
                                <thead>
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
                                </thead>
                                <tbody>
                                    <?php        

                                    // query to executre
                                    $sql = "SELECT * FROM animals";

                                    // run query
                                    $result = $conn->query($sql);

                                    // check if query has results
                                    if($result !== false && $result->num_rows > 0) {
                                        // display results of query
                                        while($row = $result->fetch_assoc()) {
                                            echo 
                                                '<tr id="' . $row["AnimalID"] . '">' .
                                                '<td>' .
                                                '<span class="tabledit-span tabledit-identifier">' . $row["AnimalID"] . '</span>' .
                                                '<input class="tabledit-input tabledit-identifier" type="hidden" name="AnimalID" value="' . $row["AnimalID"] . '" disabled>' .
                                                '</td>' .

                                                '<td class="tabledit-view-mode">' .
                                                '<span class="tabledit-span" display: inline;>' . $row["Name"] . '</span>' .
                                                '<input class="tabledit-input form-control input-sm" type="text" name="Name" value="' . $row["Name"] . '" style="display:none;" disabled>' .
                                                '</td>' .

                                                '<td class="tabledit-view-mode">' .
                                                '<span class="tabledit-span" display: inline;">' . $row["Breed"] . '</span>' .
                                                '<input class="tabledit-input form-control input-sm" type="text" name="Breed" value="' . $row["Breed"] . '" style="display:none;" disabled>' .
                                                '</td>' .

                                                '<td class="tabledit-view-mode">' .
                                                '<span class="tabledit-span" display: inline;>' . $row["Species"] . '</span>' .
                                                '<input class="tabledit-input form-control input-sm" type="text" name="Species" value="' . $row["Species"] . '" style="display:none;" disabled>' .
                                                '</td>' .

                                                '<td class="tabledit-view-mode">' .
                                                '<span class="tabledit-span" style="display: inline;">' . $row["Height"] . '</span>' .
                                                '<input class="tabledit-input form-control input-sm" type="text" name="Height" value="' . $row["Height"] . '" style="display:none;" disabled>' .
                                                '</td>' .

                                                '<td class="tabledit-view-mode">' .
                                                '<span class="tabledit-span" style="display: inline;">' . $row["Weight"] . '</span>' .
                                                '<input class="tabledit-input form-control input-sm" type="text" name="Weight" value="' . $row["Weight"] . '" style="display:none;" disabled>' .
                                                '</td>' .

                                                '<td class="tabledit-view-mode">' .
                                                '<span class="tabledit-span" style="display: inline;">' . $row["DOB"] . '</span>' .
                                                '<input class="tabledit-input form-control input-sm" type="text" name="DOB" value="' . $row["DOB"] . '" style="display:none;" disabled>' .
                                                '</td>' .

                                                '<td class="tabledit-view-mode">' .
                                                '<span class="tabledit-span" style="display: inline;">' . $row["Arrival_Date"] . '</span>' .
                                                '<input class="tabledit-input form-control input-sm" type="text" name="Arrival_Date" value="' . $row["Arrival_Date"] . '" style="display:none;" disabled>' .
                                                '</td>' .

                                                '<td class="tabledit-view-mode">' .
                                                '<span class="tabledit-span" style="display: inline;">' . $row["Color"] . '</span>' .
                                                '<input class="tabledit-input form-control input-sm" type="text" name="Color" value="' . $row["Color"] . '" style="display:none;" disabled>' .
                                                '</td>' .

                                                '<td class="tabledit-view-mode">' .
                                                '<span class="tabledit-span" display: inline;>' . $row["Available"] . '</span>' .
                                                '<input class="tabledit-input form-control input-sm" type="text" name="Available" value="' . $row["Available"] . '" style="display:none;" disabled>' .
                                                '</td>' .

                                                '<td class="tabledit-view-mode">' .
                                                '<span class="tabledit-span" display: inline;>' . $row["ImagePath"] . '</span>' .
                                                '<input class="tabledit-input form-control input-sm" type="text" name="ImagePath" value="' . $row["ImagePath"] . '" style="display:none;" disabled>' .
                                                '</td>';
                                        }
                                    } 

                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end of Animals table display -->

                <!-- start of Applications table display -->
                <div id="applications" class="tabcontent"> 
                    <div class="scroll">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="applications-table">
                                <thead>
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
                                </thead>
                                <tbody>
                                    <?php        

                                    // query to execute
                                    $sql = "SELECT * FROM applications";

                                    // run query
                                    $result = $conn->query($sql);

                                    // check if query has results
                                    if($result !== false && $result->num_rows > 0) {
                                        // display results of query
                                        while($row = $result->fetch_assoc()) {
                                            echo 
                                                '<tr id="' . $row["ApplicationID"] . '">' .
                                                '<td>' .
                                                '<span class="tabledit-span tabledit-identifier">' . $row["ApplicationID"] . '</span>' .
                                                '<input class="tabledit-input tabledit-identifier" type="hidden" name="ApplicationID" value="' . $row["ApplicationID"] . '" disabled>' .
                                                '</td>' .

                                                '<td class="tabledit-view-mode">' .
                                                '<span class="tabledit-span" display: inline;>' . $row["ApplicantID"] . '</span>' .
                                                '<input class="tabledit-input form-control input-sm" type="text" name="ApplicantID" value="' . $row["ApplicantID"] . '" style="display:none;" disabled>' .
                                                '</td>' .

                                                '<td class="tabledit-view-mode">' .
                                                '<span class="tabledit-span" display: inline;">' . $row["AnimalID"] . '</span>' .
                                                '<input class="tabledit-input form-control input-sm" type="text" name="AnimalID" value="' . $row["AnimalID"] . '" style="display:none;" disabled>' .
                                                '</td>' .

                                                '<td class="tabledit-view-mode">' .
                                                '<span class="tabledit-span" display: inline;>' . $row["HomeType"] . '</span>' .
                                                '<input class="tabledit-input form-control input-sm" type="text" name="HomeType" value="' . $row["HomeType"] . '" style="display:none;" disabled>' .
                                                '</td>' .

                                                '<td class="tabledit-view-mode">' .
                                                '<span class="tabledit-span" style="display: inline;">' . $row["LandlordApproval"] . '</span>' .
                                                '<input class="tabledit-input form-control input-sm" type="text" name="LandlordApproval" value="' . $row["LandlordApproval"] . '" style="display:none;" disabled>' .
                                                '</td>';
                                        }
                                    } 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div> 
                </div>
                <!-- end of Applications table display -->

                <!-- start of Users table display -->
                <div id="users" class="tabcontent"> 
                    <div class="scroll">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered" id="users-table">
                                <thead>
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
                                </thead>
                                <tbody>
                                    <?php        

                                    // query to execute
                                    $sql = "SELECT * FROM users";

                                    // run query
                                    $result = $conn->query($sql);

                                    // check if query has results
                                    if($result !== false && $result->num_rows > 0) {
                                        // display results of query
                                        while($row = $result->fetch_assoc()) {
                                            echo 
                                                '<tr id="' . $row["UserID"] . '">' .
                                                '<td>' .
                                                '<span class="tabledit-span tabledit-identifier">' . $row["UserID"] . '</span>' .
                                                '<input class="tabledit-input tabledit-identifier" type="hidden" name="UserID" value="' . $row["UserID"] . '" disabled>' .
                                                '</td>' .

                                                '<td class="tabledit-view-mode">' .
                                                '<span class="tabledit-span" display: inline;>' . $row["Email"] . '</span>' .
                                                '<input class="tabledit-input form-control input-sm" type="text" name="Email" value="' . $row["Email"] . '" style="display:none;" disabled>' .
                                                '</td>' .

                                                '<td class="tabledit-view-mode">' .
                                                '<span class="tabledit-span" display: inline;">' . $row["Password"] . '</span>' .
                                                '<input class="tabledit-input form-control input-sm" type="text" name="Password" value="' . $row["Password"] . '" style="display:none;" disabled>' .
                                                '</td>' .

                                                '<td class="tabledit-view-mode">' .
                                                '<span class="tabledit-span" display: inline;>' . $row["FirstName"] . '</span>' .
                                                '<input class="tabledit-input form-control input-sm" type="text" name="FirstName" value="' . $row["FirstName"] . '" style="display:none;" disabled>' .
                                                '</td>' .

                                                '<td class="tabledit-view-mode">' .
                                                '<span class="tabledit-span" style="display: inline;">' . $row["LastName"] . '</span>' .
                                                '<input class="tabledit-input form-control input-sm" type="text" name="LastName" value="' . $row["LastName"] . '" style="display:none;" disabled>' .
                                                '</td>' .

                                                '<td class="tabledit-view-mode">' .
                                                '<span class="tabledit-span" style="display: inline;">' . $row["MiddleInitial"] . '</span>' .
                                                '<input class="tabledit-input form-control input-sm" type="text" name="MiddleInitial" value="' . $row["MiddleInitial"] . '" style="display:none;" disabled>' .
                                                '</td>';
                                        }
                                    } 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- end of Users table display -->

                <div id="settings" class="tabcontent"> settings </div>
            </div>
        </div>

    </body>
</html>