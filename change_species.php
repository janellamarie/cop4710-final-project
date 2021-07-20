<?php
if(isset($_POST['value'])) {
    $username = $_POST['value'];
    //your database query
    $query=something;
    if ($query) {
        echo 'success';
    }
    else {
        echo 'something went wrong';
    }
}
?>