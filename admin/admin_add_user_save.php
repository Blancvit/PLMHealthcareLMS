<?php
include('dbcon.php');
include('session.php');

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$username = $_POST['username'];
$password = $_POST['password'];

$query_user = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$session_id'") or die(mysqli_error($conn));
$row_user = mysqli_fetch_array($query_user);
$user_username = $row_user['username'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'") or die(mysqli_error($conn));
$count = mysqli_num_rows($query);

if ($count > 0) {
    // User already exists, display jGrowl message
    $response = array('status' => 'error', 'message' => 'Admin User Already Exists');
} else {
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    mysqli_query($conn, "INSERT INTO users (username, password, firstname, lastname) VALUES ('$username', '$hashedPassword', '$firstname', '$lastname')") or die(mysqli_error($conn));
    mysqli_query($conn, "INSERT INTO activity_log (date, username, action) VALUES (DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i:%s %p'), '$user_username', 'Added Admin User $username')") or die(mysqli_error($conn));

    // User added successfully, display jGrowl message
    $response = array('status' => 'success', 'message' => 'Admin User Added Successfully');
}

// Convert the response array to JSON format
echo json_encode($response);
?>
