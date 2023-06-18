<?php
include('dbcon.php');
include('session.php');
$id = $_POST['id'];

$result = mysqli_query($conn, "DELETE FROM class_quiz where class_quiz_id='$id'") or die(mysqli_error($conn));
if ($result) {
    // Deletion successful
    echo "success";
} else {
    // Deletion failed
    echo "error";
}
?>
