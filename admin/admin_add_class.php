<?php
include('dbcon.php');
include('session.php');

$class_name = $_POST['class_name'];

$query = mysqli_query($conn, "SELECT * FROM class WHERE class_name = '$class_name' ") or die(mysqli_error($conn));
$count = mysqli_num_rows($query);

$query_user = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$session_id'") or die(mysqli_error($conn));
$row_user = mysqli_fetch_array($query_user);
$user_username = $row_user['username'];

if ($count > 0) {
    // Class already exists, display jGrowl message
    $response = array('status' => 'error', 'message' => 'Class Already Exists');
} else {
    mysqli_query($conn, "INSERT INTO class (class_name) VALUES ('$class_name')") or die(mysqli_error($conn));
    mysqli_query($conn, "INSERT INTO activity_log (date,username,action) VALUES(DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i:%s %p'),'$user_username','Added Class $class_name')") or die(mysqli_error($conn));

    // Class added successfully, display jGrowl message
    $response = array('status' => 'success', 'message' => 'Class Added Successfully');
}

// Convert the response array to JSON format
echo json_encode($response);
?>
