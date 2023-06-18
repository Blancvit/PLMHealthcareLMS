<?php
include('dbcon.php');
$id = $_POST['id'];
mysqli_query($conn,"DELETE FROM teacher_class_student WHERE teacher_class_student_id = '$id'")or die(mysqli_error($conn));
?>

