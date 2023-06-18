<?php
include('dbcon.php');
include('session.php');

$un = $_POST['un'];
$fn = $_POST['fn'];
$ln = $_POST['ln'];
$email = $_POST['email'];
$class_id = $_POST['class_id'];

$query = mysqli_query($conn, "SELECT * FROM student WHERE username = '$un' ") or die(mysqli_error($conn));
$count = mysqli_num_rows($query);

if ($count > 0) {
    // Class already exists, display jGrowl message
    $response = array('status' => 'error', 'message' => 'Student Already Exists');
} else {
    mysqli_query($conn, "INSERT INTO student (username, password, firstname, lastname, location, class_id, status, email) VALUES ('$un', '$un', '$fn', '$ln', '', '$class_id', 'Unregistered', '$email')") or die(mysqli_error($conn));

    // Class added successfully, display jGrowl message
    $response = array('status' => 'success', 'message' => 'Student Added Successfully');
}

// Convert the response array to JSON format
echo json_encode($response);
?>