<?php
include('session.php');
include('dbcon.php');

$name = $_POST['name'];
$filedesc = $_POST['desc'];
$deadline = $_POST['deadline'];
$id_class = $_POST['id_class'];
$get_id  = $_GET['id'];

$formattedDeadline = date('Y-m-d h:i A', strtotime($deadline));
$input_name = basename($_FILES['uploaded_file']['name']);
$name_notification = 'Added a Demonstration named' . " " . '<b>' . $name . '</b>' . " in:";

if (empty($input_name)) {

    mysqli_query($conn, "INSERT INTO assignment (fdesc, fdatein, teacher_id, fname, class_id, deadline) VALUES ('$filedesc', DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i %p'), '$session_id', '$name', '$id_class', '$formattedDeadline')") or die(mysqli_error($conn));
    mysqli_query($conn, "INSERT INTO notification (teacher_class_id, notification, date_of_notification, link) VALUES ('$get_id', '$name_notification', DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i %p'), 'student_retdem.php')") or die(mysqli_error($conn));

    $response = array('success' => true);
} else {
    $rd2 = mt_rand(1000, 9999) . "_File";
    $filename = basename($_FILES['uploaded_file']['name']);
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $newname = "admin/uploads/" . $rd2 . "_" . $filename;

    if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $newname)) {


        mysqli_query($conn, "INSERT INTO assignment (fdesc, floc, fdatein, teacher_id, fname, class_id, deadline) VALUES ('$filedesc', '$newname', DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i %p'), '$session_id', '$name', '$id_class', '$formattedDeadline')") or die(mysqli_error($conn));
        mysqli_query($conn, "INSERT INTO notification (teacher_class_id, notification, date_of_notification, link) VALUES ('$get_id', '$name_notification', DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i %p'), 'student_retdem.php')") or die(mysqli_error($conn));
        $response = array('success' => true);
    } else {
        $response = array('success' => false);
    }
}

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);
