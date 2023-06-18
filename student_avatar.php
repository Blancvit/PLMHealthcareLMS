<?php
include('dbcon.php');
include('session.php');

$image = addslashes(file_get_contents($_FILES['image']['tmp_name']));
$image_name = addslashes($_FILES['image']['name']);
$image_size = getimagesize($_FILES['image']['tmp_name']);

move_uploaded_file($_FILES["image"]["tmp_name"], "admin/uploads/" . $_FILES["image"]["name"]);
$location = "uploads/" . $_FILES["image"]["name"];

// Update the student's location in the database
$query = "UPDATE student SET location = '$location' WHERE student_id = '$session_id'";
$result = mysqli_query($conn, $query);

if ($result) {
    // Return success message as a response to AJAX
    $response = array(
        'status' => 'success',
        'message' => 'Picture uploaded successfully'
    );
    echo json_encode($response);
} else {
    // Return error message as a response to AJAX
    $response = array(
        'status' => 'error',
        'message' => 'Error uploading picture'
    );
    echo json_encode($response);
}
