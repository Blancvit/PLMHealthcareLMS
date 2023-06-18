<?php
include('dbcon.php');
include('session.php');

$school_year = $_POST['school_year'];

$query = mysqli_query($conn, "SELECT * FROM school_year WHERE school_year = '$school_year'") or die(mysqli_error($conn));
$count = mysqli_num_rows($query);

$query_user = mysqli_query($conn, "SELECT * FROM users WHERE user_id = '$session_id'") or die(mysqli_error($conn));
$row_user = mysqli_fetch_array($query_user);
$user_username = $row_user['username'];

if ($count > 0) {
    // Class already exists, display jGrowl message
    $response = array('status' => 'error', 'message' => 'School Year Already Exists');
} else {
    mysqli_query($conn, "INSERT INTO school_year (school_year) values('$school_year')") or die(mysqli_error($conn));
    mysqli_query($conn, "INSERT INTO activity_log (date,username,action) values(DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i:%s %p'),'$user_username','Added School Year $school_year')") or die(mysqli_error($conn));

    // Class added successfully, display jGrowl message
    $response = array('status' => 'success', 'message' => 'School Year Added Successfully');
}

// Convert the response array to JSON format
echo json_encode($response);
?>
