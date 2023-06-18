<?php
include('dbcon.php');
include('session.php');
$get_id = $_SESSION['id'];
if (!isset($_SESSION['class_quiz_id']) || empty($_SESSION['class_quiz_id'])) {
    // Redirect to the quiz list
	?>
    <script>
	  window.location = 'student_quiz_list.php<?php echo '?id='.$get_id; ?>'; 
	</script>
	<?php
    exit();
}
$class_quiz_id = $_SESSION['class_quiz_id'];

$sql = mysqli_query($conn, "SELECT * FROM student_class_quiz WHERE student_id = '$session_id' and class_quiz_id = '$class_quiz_id'") or die(mysqli_error($conn));
$row = mysqli_fetch_array($sql);
$quiz_time = $row['student_quiz_time'];

$sqlp = mysqli_query($conn, "SELECT * FROM class_quiz where class_quiz_id = '$class_quiz_id'") or die(mysqli_error($conn));
$rowp = mysqli_fetch_array($sqlp);
if ($quiz_time > 0) {
    mysqli_query($conn, "UPDATE student_class_quiz SET student_quiz_time = student_quiz_time - 1 WHERE student_id = '$session_id' and class_quiz_id = '$class_quiz_id'") or die(mysqli_error($conn));
    $_SESSION['take_exam'] = 'continue';

    $minutes = floor($quiz_time / 60);
    $seconds = $quiz_time % 60;
    $formatted_time = sprintf('%02d:%02d', $minutes, $seconds);
    echo $formatted_time;
} else {
    $_SESSION['take_exam'] = 'denied';
    echo '00:00'; // Display 00:00 when the timer reaches 0
}
?>
