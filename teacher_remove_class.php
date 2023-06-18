<?php
include('dbcon.php');

$get_id = $_POST['id'];
mysqli_query($conn,"DELETE FROM teacher_class  WHERE  teacher_class_id = '$get_id' ")or die(mysqli_error($conn));
mysqli_query($conn,"DELETE FROM teacher_class_student  WHERE  teacher_class_id = '$get_id' ")or die(mysqli_error($conn));
mysqli_query($conn,"DELETE FROM teacher_class_announcements  WHERE  teacher_class_id = '$get_id' ")or die(mysqli_error($conn));
mysqli_query($conn,"DELETE FROM teacher_notification  WHERE  teacher_class_id = '$get_id' ")or die(mysqli_error($conn));
mysqli_query($conn,"DELETE FROM class_subject_overview WHERE  teacher_class_id = '$get_id' ")or die(mysqli_error($conn));
?>