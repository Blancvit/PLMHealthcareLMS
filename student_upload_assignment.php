<?php
include('dbcon.php');
include('session.php');

$assignment_id = $_POST['id'];
$name = $_POST['name'];
$get_id = $_POST['get_id'];
$filedesc = $_POST['desc'];
$vidlink = $_POST['link'];
$name_notification = "Submitted RETDEM";

// Move the uploaded file to a desired location
$rd2 = mt_rand(1000, 9999) . "_File";
$filename = basename($_FILES['uploaded_file']['name']);
$ext = pathinfo($filename, PATHINFO_EXTENSION);
$newname = "admin/uploads/" . $rd2 . "_" . $filename;

move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $newname);

    $qry2 = "INSERT INTO student_assignment (fdesc, floc, assignment_fdatein, fname, assignment_id, student_id, vidlink) VALUES ('$filedesc', '$newname', DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i %p'), '$name', '$assignment_id', '$session_id', '$vidlink')";
    mysqli_query($conn, $qry2) or die(mysqli_error($conn));

    $qry3 = "INSERT INTO teacher_notification (teacher_class_id, notification, date_of_notification, link, student_id, assignment_id) VALUES ('$get_id', '$name_notification', DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i %p'), 'teacher_view_submit_demo.php', '$session_id', '$assignment_id')";
    mysqli_query($conn, $qry3) or die(mysqli_error($conn));

