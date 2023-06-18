<?php
include('dbcon.php');
include('session.php');

$id = $_POST['selector'];
$N = count($id);
$successCount = 0;

for ($i = 0; $i < $N; $i++) {
    $subjectId = $id[$i];
	$result = mysqli_query($conn,"DELETE FROM student where student_id='$id[$i]'");
    $result1 = 	mysqli_query($conn,"DELETE FROM teacher_class_student where student_id='$id[$i]'");
    if ($result && $result1) {
        $successCount++;
    }
}

if ($successCount > 0) {
    // Deletion succeeded
    echo "success";
} else {
    // Deletion failed
    echo "error";
}
?>
