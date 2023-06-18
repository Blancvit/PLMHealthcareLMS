<?php
include('dbcon.php');
include('session.php');

$subject_id = $_POST['subject_id'];
$class_id = $_POST['class_id'];
$school_year = $_POST['school_year'];

$query = mysqli_query($conn, "SELECT * FROM teacher_class WHERE subject_id = '$subject_id' AND class_id = '$class_id' AND teacher_id = '$session_id' AND school_year = '$school_year' ") or die(mysqli_error($conn));
$count = mysqli_num_rows($query);

if ($count > 0) {
    echo "true"; // Class already exists
} else {
    mysqli_query($conn, "INSERT INTO teacher_class (teacher_id, subject_id, class_id, thumbnails, school_year) VALUES ('$session_id', '$subject_id', '$class_id', 'admin/uploads/thumbnails.jpg', '$school_year')") or die(mysqli_error($conn));

    $teacher_class = mysqli_query($conn, "SELECT * FROM teacher_class ORDER BY teacher_class_id DESC") or die(mysqli_error($conn));
    $teacher_row = mysqli_fetch_array($teacher_class);
    $teacher_id = $teacher_row['teacher_class_id'];

    $insert_query = mysqli_query($conn, "SELECT * FROM student WHERE class_id = '$class_id'") or die(mysqli_error($conn));
    while ($row = mysqli_fetch_array($insert_query)) {
        $id = $row['student_id'];
        mysqli_query($conn, "INSERT INTO teacher_class_student (teacher_id, student_id, teacher_class_id) VALUES ('$session_id', '$id', '$teacher_id')") or die(mysqli_error($conn));
    }
    
    echo "false"; // Class added successfully
}
?>