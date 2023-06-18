<?php
include('dbcon.php');
include('session.php');

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Perform the deletion query for the first table
    $delete_query1 = mysqli_query($conn, "DELETE FROM notification WHERE notification_id = '$id'") or die(mysqli_error($conn));

    // Perform the deletion query for the second table
    $delete_query2 = mysqli_query($conn, "DELETE FROM notification_read WHERE notification_id = '$id'") or die(mysqli_error($conn));

    if ($delete_query1 && $delete_query2) {
        // Deletion successful
        echo "success";
    } else {
        // Deletion failed
        echo "error";
    }
}
?>
