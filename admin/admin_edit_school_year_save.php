<?php
include('dbcon.php');
include('session.php');
$get_id = $_GET['id'];

$school_year = $_POST['school_year'];

mysqli_query($conn,"UPDATE school_year SET school_year = '$school_year' WHERE school_year_id = '$get_id' ")or die(mysqli_error($conn));
?>
