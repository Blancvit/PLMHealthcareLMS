<?php
session_start();
include('dbcon.php');
$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username' AND password='$password'") or die(mysqli_error($conn));
$count = mysqli_num_rows($query);
$row = mysqli_fetch_array($query);

if ($count > 0) {

    $_SESSION['id'] = $row['user_id'];

    echo 'true';
    mysqli_query($conn, "INSERT INTO user_log (username,login_date,user_id) VALUES('$username',DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i:%s %p')," . $row['user_id'] . ")") or die(mysqli_error($conn));
} else {
    echo 'false';
}
?>