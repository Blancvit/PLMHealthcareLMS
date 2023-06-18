<?php
include('dbcon.php');
include('session.php');

$id_num = $_POST['un'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];

$query = mysqli_query($conn, "SELECT * FROM teacher WHERE username = '$id_num' ") or die(mysqli_error($conn));
$count = mysqli_num_rows($query);

if ($count > 0) {
    // Class already exists, display jGrowl message
    $response = array('status' => 'error', 'message' => 'Teacher Already Exists');
} else {
    mysqli_query($conn, "INSERT INTO teacher (firstname,lastname,location,username) VALUES ('$firstname','$lastname','uploads/NO-IMAGE-AVAILABLE.jpg','$id_num')") or die(mysqli_error($conn));

    // Class added successfully, display jGrowl message
    $response = array('status' => 'success', 'message' => 'Teacher Added Successfully');
}

// Convert the response array to JSON format
echo json_encode($response);
