<?php include('dbcon.php'); ?>
<?php include('session.php'); ?>
<?php $get_id = $_GET['id']; ?>

<?php
$question = $_POST['question'];
$type = $_POST['question_type'];

$ans1 = $_POST['ans1'];
$ans2 = $_POST['ans2'];
$ans3 = $_POST['ans3'];
$ans4 = $_POST['ans4'];

if ($type == '2') {
    $answer = $_POST['correctt'];
    mysqli_query($conn, "INSERT INTO quiz_question (quiz_id, question_text, date_added, answer, question_type_id) 
			VALUES ('$get_id', '$question', DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i %p'), '$answer', '$type')") or die(mysqli_error($conn));
} else if ($type == '1') {
    $answer = $_POST['answer'];
    mysqli_query($conn, "INSERT INTO quiz_question (quiz_id, question_text, date_added, answer, question_type_id) 
		VALUES ('$get_id', '$question', DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i %p'), '$answer', '$type')") or die(mysqli_error($conn));
    $quiz_question_id = mysqli_insert_id($conn); // Get the last inserted ID

    mysqli_query($conn, "INSERT INTO answer (quiz_question_id, answer_text, choices) VALUES ('$quiz_question_id', '$ans1', 'A')") or die(mysqli_error($conn));
    mysqli_query($conn, "INSERT INTO answer (quiz_question_id, answer_text, choices) VALUES ('$quiz_question_id', '$ans2', 'B')") or die(mysqli_error($conn));
    mysqli_query($conn, "INSERT INTO answer (quiz_question_id, answer_text, choices) VALUES ('$quiz_question_id', '$ans3', 'C')") or die(mysqli_error($conn));
    mysqli_query($conn, "INSERT INTO answer (quiz_question_id, answer_text, choices) VALUES ('$quiz_question_id', '$ans4', 'D')") or die(mysqli_error($conn));
} else {
    //FOR SIMULATION VIDEO
    $rd2 = mt_rand(1000, 9999) . "_File";
    $filename = basename($_FILES['uploaded_file']['name']);
    $newname = "admin/uploads/" . $rd2 . "_" . $filename;

    if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $newname)) {
        mysqli_query($conn, "INSERT INTO quiz_question (quiz_id, question_text, date_added, answer, question_type_id, floc) 
				VALUES ('$get_id', '$question', DATE_FORMAT(NOW(), '%Y-%m-%d %h:%i %p'), '', '$type', '$newname')") or die(mysqli_error($conn));
    } else {
        // Handle the case where file upload fails
    }
}
