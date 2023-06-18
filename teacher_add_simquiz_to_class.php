<?php
include('session.php');
include('dbcon.php');

$result = $_POST['quiz_id'];
$result_explode = explode('|', $result);
$quiz_id = $result_explode[0];
$area = $result_explode[1];
$time = $_POST['time'] * 60;
$id = $_POST['selector'];

$name_notification = 'Added a Simulation / Quiz in: ';
$response = array('success' => true);

$N = count($id);
for ($i = 0; $i < $N; $i++) {
    // Check if the quiz already exists in the class
    $checkQuery = "SELECT * FROM class_quiz WHERE teacher_class_id = '$id[$i]' AND quiz_id = '$quiz_id'";
    $checkResult = mysqli_query($conn, $checkQuery);
    if (mysqli_num_rows($checkResult) > 0) {
        // Quiz already exists in the class
        $response['success'] = false;
        break; // Exit the loop
    }

    // Add the quiz to the class
    mysqli_query($conn, "INSERT INTO class_quiz (teacher_class_id, quiz_time, quiz_id, area, date_added) VALUES ('$id[$i]', '$time', '$quiz_id', '$area', DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i %p'))") or die(mysqli_error($conn));
    mysqli_query($conn, "INSERT INTO notification (teacher_class_id, notification, date_of_notification, link) VALUES ('$id[$i]', '$name_notification', DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i %p'), 'student_quiz_list.php')") or die(mysqli_error($conn));
}

echo json_encode($response);
?>
