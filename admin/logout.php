<?php
include('dbcon.php');
include('session.php');
mysqli_query($conn, "UPDATE user_log SET logout_date = DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i:%s %p') WHERE user_id = '$session_id' ") or die(mysqli_error($conn));

session_destroy();
header('location:index.php');
