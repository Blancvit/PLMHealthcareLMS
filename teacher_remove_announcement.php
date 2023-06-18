<?php include('dbcon.php'); ?>
<?php include('session.php'); ?>

<?php
$id = $_POST['id'];
mysqli_query($conn, "DELETE FROM teacher_class_announcements WHERE teacher_class_announcements_id = '$id'") or die(mysqli_error($conn));
mysqli_query($conn, "DELETE FROM teacher_class_announcements WHERE teacher_class_announcements_id = '$id'") or die(mysqli_error($conn));
?>

