<?php include('dbcon.php'); ?>
<?php
$id = $_POST['id'];
mysqli_query($conn,"DELETE FROM message WHERE message_id = '$id'")or die(mysqli_error($conn));
?>

