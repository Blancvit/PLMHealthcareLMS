<?php
include('dbcon.php');
include('session.php');

$id = $_POST['id'];

// Perform the deletion query for the first table
$delete_query1 = mysqli_query($conn, "DELETE FROM assignment WHERE assignment_id = '$id' ") or die(mysqli_error($conn));

if ($delete_query1) {
    // Deletion successful
    echo "success";
} else {
    // Deletion failed
    echo "error";
}
