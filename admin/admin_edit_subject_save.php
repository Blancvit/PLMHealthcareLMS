<?php include('dbcon.php'); ?>
<?php include('session.php'); ?>
<?php $get_id = $_GET['id']; ?>

<?php
$subject_code = $_POST['subject_code'];
$title = $_POST['title'];
$unit = $_POST['unit'];
$description = $_POST['description'];

mysqli_query($conn, "UPDATE subject SET subject_code = '$subject_code', subject_title = '$title', unit  = '$unit', description = '$description' WHERE subject_id = '$get_id' ") or die(mysqli_error($conn));
mysqli_query($conn, "INSERT INTO activity_log (date,username,action) values(DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i:%s %p'),'$user_username','Edit Subject $subject_code')") or die(mysqli_error($conn));
?>