<?php
include('dbcon.php');

$id = $_POST['id'];
$post_id = $_POST['post_id'];
$get_id = $_POST['get_id'];
$grade = $_POST['grade'];

// Update the grade in the student_assignment table
$result = mysqli_query($conn, "UPDATE student_assignment SET grade = '$grade' WHERE student_assignment_id = '$id'") or die(mysqli_error($conn));
$query = mysqli_query($conn, "SELECT * FROM student_assignment 
LEFT JOIN student on student.student_id  = student_assignment.student_id
WHERE assignment_id = '$post_id'  ORDER BY assignment_fdatein DESC") or die(mysqli_error($conn));
$row = mysqli_fetch_array($query);
$name = $row['fname'];
if ($result) {
    // Grade update successful

    // Add a notification
    $notification = 'Grade updated for RETDEM named: ' . '<b>' . $name . '</b>' . ' in ';

    mysqli_query($conn, "INSERT INTO notification (teacher_class_id, notification, date_of_notification, link) VALUES ('$get_id', '$notification', NOW(), 'student_retdem.php')") or die(mysqli_error($conn));

    // Output success message
    echo "success";
} else {
    // Grade update failed
    echo "error";
}
