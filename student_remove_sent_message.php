<?php include('dbcon.php'); ?>
<?php
$id = $_POST['id'];
mysqli_query($conn, "DELETE FROM message_sent WHERE message_sent_id = '$id'") or die(mysqli_error($conn));
?>

