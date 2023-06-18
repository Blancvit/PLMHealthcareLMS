<?php
include('dbcon.php');
include('session.php');

$response = array(); // Initialize the response array

$get_id = $_GET['id'];
$subject_id = $_GET['subject_id'];

$content = $_POST['content'];
$query = mysqli_query($conn, "UPDATE class_subject_overview SET content = '$content' WHERE class_subject_overview_id = '$subject_id'");

if ($query) {
    // Update successful
    $response['success'] = true;
    $response['message'] = 'Subject Overview Updated Successfully';
} else {
    // Update failed
    $response['error'] = true;
    $response['message'] = 'Error updating Subject Overview';
}

// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>
