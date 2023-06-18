<?php include('session.php'); ?>
<?php include('dbcon.php'); ?>

<?php
$quiz_title = mysqli_real_escape_string($conn, $_POST['quiz_title']);
$description = mysqli_real_escape_string($conn, $_POST['description']);
$area = mysqli_real_escape_string($conn, $_POST['area']);
mysqli_query($conn, "INSERT INTO quiz (quiz_title,quiz_description,area,date_added,teacher_id) VALUES('$quiz_title','$description','$area',DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i %p'),'$session_id')") or die(mysqli_error($conn));
?>