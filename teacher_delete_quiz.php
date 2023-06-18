<?php
include('dbcon.php');
include('session.php');

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Perform the deletion query for the first table
    $delete_query1 = mysqli_query($conn, "DELETE FROM quiz_question WHERE quiz_id='$id'") or die(mysqli_error($conn));
    $delete_query2 = mysqli_query($conn, "DELETE FROM quiz WHERE quiz_id='$id'") or die(mysqli_error($conn));
    $delete_query3 = mysqli_query($conn, "DELETE FROM notification WHERE notification_id = '$id'") or die(mysqli_error($conn));
    $delete_query4 = mysqli_query($conn, "DELETE FROM class_quiz WHERE quiz_id = '$id'") or die (mysqli_errno($conn));

    if ($delete_query1 && $delete_query2 && $delete_query3 && $delete_query4) {
        // Deletion successful
        echo "success";
    } else {
        // Deletion failed
        echo "error";
    }
}
