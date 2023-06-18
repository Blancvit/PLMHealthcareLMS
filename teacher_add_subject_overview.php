<?php
include('dbcon.php');
include('session.php');

$get_id = $_GET['id'];
$content = $_POST['subject_content'];

$query = mysqli_query($conn, "INSERT INTO class_subject_overview (teacher_class_id, subject_content) VALUES ('$get_id', '$content')");

// Return a success response
$response = array('status' => 'success', 'message' => 'Subject Overview Added Successfully');

// Convert the response array to JSON format
echo json_encode($response);
?>