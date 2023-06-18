<?php
include('dbcon.php');
include('session.php');
$get_id = $_GET['id'];

$class_name = $_POST['class_name'];

mysqli_query($conn,"UPDATE class SET class_name = '$class_name' WHERE class_id = '$get_id' ")or die(mysqli_error($conn));
?>
