<?php include('dbcon.php'); ?>
<?php include('session.php'); ?>
<?php $get_id = $_GET['id']; ?>


<?php
$content = $_POST['content'];
mysqli_query($conn, "INSERT INTO teacher_class_announcements (teacher_class_id,teacher_id,content,date) VALUES('$get_id','$session_id','$content',DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i %p'))") or die(mysqli_error($conn));
mysqli_query($conn, "INSERT INTO notification (teacher_class_id,notification,date_of_notification,link) VALUES('$get_id','Add Annoucements',DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i %p'),'announcements_student.php')") or die(mysqli_error($conn));
?>
