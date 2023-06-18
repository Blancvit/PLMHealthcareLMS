<?php
include('dbcon.php');
include('session.php');
mysqli_query($conn, "update user_log_students set logout_date = NOW() where user_id = '$session_id' ") or die(mysqli_error($conn));

session_destroy();
header('location:index.php');
