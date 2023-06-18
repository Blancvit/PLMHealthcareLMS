<?php
include('dbcon.php');
include('session.php');
$student_id = $_POST['student_id'];
$my_message = $_POST['my_message'];

$query = mysqli_query($conn, "SELECT * FROM student WHERE student_id = '$student_id'") or die(mysqli_error($conn));
$row = mysqli_fetch_array($query);
$name = $row['firstname'] . " " . $row['lastname'];

$query1 = mysqli_query($conn, "SELECT * FROM student WHERE student_id = '$session_id'") or die(mysqli_error($conn));
$row1 = mysqli_fetch_array($query1);
$name1 = $row1['firstname'] . " " . $row1['lastname'];


mysqli_query($conn, "INSERT INTO message (reciever_id,content,date_sended,sender_id,reciever_name,sender_name) VALUES('$student_id','$my_message',DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i:%s %p'),'$session_id','$name','$name1')") or die(mysqli_error($conn));
mysqli_query($conn, "INSERT INTO message_sent (reciever_id,content,date_sended,sender_id,reciever_name,sender_name) VALUES('$student_id','$my_message',DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i:%s %p'),'$session_id','$name','$name1')") or die(mysqli_error($conn));
?>