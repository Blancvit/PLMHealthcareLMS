<?php
session_start();
require_once 'dbcon.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query_teacher = mysqli_query($conn, "SELECT * FROM teacher WHERE username='$username'") or die(mysqli_error($conn));
$num_row_teacher = mysqli_num_rows($query_teacher);
$row_teacher = mysqli_fetch_array($query_teacher);

if ($num_row_teacher > 0 && (password_verify($password, $row_teacher['password']) || $password === $row_teacher['password'])) {
    $_SESSION['id'] = $row_teacher['teacher_id'];
    echo 'true_teacher';
} else {
    echo 'false';
}
