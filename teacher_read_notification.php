<?php
include('dbcon.php');
include('session.php');

if (isset($_POST['messages'])) {
    $messageIds = $_POST['messages'];

    // Loop through the selected message IDs
    foreach ($messageIds as $messageId) {
        // Check if the notification has already been marked as read by the student
        $checkQuery = "SELECT * FROM notification_read_teacher WHERE teacher_id = '$session_id' AND notification_id = '$messageId'";
        $result = mysqli_query($conn, $checkQuery);
        $count = mysqli_num_rows($result);

        if ($count == 0) {
            // The notification hasn't been marked as read by the student, so insert the record
            mysqli_query($conn, "INSERT INTO notification_read_teacher (teacher_id, student_read, notification_id) VALUES ('$session_id', 'yes', '$messageId')") or die(mysqli_error($conn));
        }
    }

    // Return a success message
    echo "Notifications marked as read.";
} else {
    // Return an error message
    echo "No messages selected.";
}
