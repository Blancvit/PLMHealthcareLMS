<?php
include('dbcon.php');
include('session.php');

$subject_code = $_POST['subject_code'];
$title = $_POST['title'];
$unit = $_POST['unit'];
$description = $_POST['description'];
$semester = $_POST['semester'];

$query_user = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$session_id'") or die(mysqli_error($conn));
$row_user = mysqli_fetch_array($query_user);
$user_username = $row_user['username'];

// Check if the subject already exists in the database
$query = mysqli_query($conn, "SELECT * FROM subject WHERE subject_code = '$subject_code'") or die(mysqli_error($conn));
$count = mysqli_num_rows($query);

if ($count > 0) {
    // Subject already exists, return an error response
    $response = array('status' => 'error', 'message' => 'Subject already exists.');
} else {
    // Subject does not exist, insert it into the database
    mysqli_query($conn, "INSERT INTO subject (subject_code, subject_title, description, unit, semester) VALUES ('$subject_code', '$title', '$description', '$unit', '$semester')") or die(mysqli_error($conn));
    mysqli_query($conn, "INSERT INTO activity_log (date, username, action) VALUES (DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i:%s %p'), '$user_username', 'Added Subject $subject_code')") or die(mysqli_error($conn));

    // Return a success response
    $response = array('status' => 'success', 'message' => 'Subject Added Successfully');
}

// Convert the response array to JSON format
echo json_encode($response);
?>
