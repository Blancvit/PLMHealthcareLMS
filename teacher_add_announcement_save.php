<?php
include('dbcon.php');
include('session.php');

$content = $_POST['content'];		
$id = $_POST['selector'];
$N = count($id);
for($i = 0; $i < $N; $i++) {			
    mysqli_query($conn, "INSERT INTO teacher_class_announcements (teacher_class_id, teacher_id, content, date) VALUES ('$id[$i]', '$session_id', '$content', DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i %p'))") or die(mysqli_error($conn));
    mysqli_query($conn, "INSERT INTO notification (teacher_class_id, notification, date_of_notification, link) VALUES ('$id[$i]', 'Posted an Announcement in: ', DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i %p'), 'student_announcements.php')") or die(mysqli_error($conn));
}
?>