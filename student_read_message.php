<?php
include('session.php');
include('dbcon.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $selectedMessages = $_POST['messages']; // Get the array of selected message IDs

  // Update the message status to 'read' for the selected messages
  $selectedMessagesStr = implode(',', $selectedMessages);
  $updateQuery = "UPDATE message SET message_status = 'read' WHERE message_id IN ($selectedMessagesStr) AND message_status != 'read'";
  $result = mysqli_query($conn, $updateQuery);

  if ($result) {
    // Return a success response
    echo 'Messages marked as read successfully';
  } else {
    // Return an error response
    echo 'Error marking messages as read';
  }
} else {
  // Return an error response for invalid request method
  echo 'Please check at least one item';
}
?>
