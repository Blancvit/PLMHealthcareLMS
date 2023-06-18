<?php
session_start();
require_once 'dbcon.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM student WHERE username='$username'";
$result = mysqli_query($conn, $query) or die(mysqli_error($conn));
$row = mysqli_fetch_array($result);
$num_row = mysqli_num_rows($result);

if ($num_row > 0 && (password_verify($password, $row['password']) || $password === $row['password'])) {
    $_SESSION['id'] = $row['student_id'];
    echo 'true_student';
} else {
    echo 'false';
}

mysqli_close($conn);
?>
