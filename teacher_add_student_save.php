<?php include('dbcon.php'); ?>
<?php include('session.php'); ?>
<?php $get_id = $_GET['id']; ?>

<?php
$test = $_POST['test'];
$successCount = 0;
$added = false; // Flag variable to track if any students were added

for ($b = 1; $b <= $test; $b++) {
    $id = $_POST['student_id' . $b];
    $class_id = $_POST['class_id' . $b];
    $teacher_id = $_POST['teacher_id' . $b];
    $add = $_POST['add_student' . $b];

    $query = mysqli_query($conn, "SELECT * FROM teacher_class_student WHERE student_id = '$id' AND teacher_class_id = '$class_id'") or die(mysqli_error($conn));
    $count = mysqli_num_rows($query);

    if ($add == 'Add') {
        if ($count > 0) {
            // Student already in the class
            continue; // Skip to the next iteration of the loop
        } else {
            mysqli_query($conn, "INSERT INTO teacher_class_student (student_id, teacher_class_id, teacher_id) VALUES ('$id', '$class_id', '$teacher_id')") or die(mysqli_error($conn));
            $successCount++;
            $added = true; // Set the flag to indicate a student was added
        }
    }
}

if ($successCount > 0) {
    // Students added successfully
    $response = array(
        'success' => true,
        'message' => 'Student(s) added successfully'
    );
} else if ($successCount == 0) {
    // No students were added
    $response = array(
        'empty' => true,
        'message' => 'No student selected to add'
    );
}


// Return the JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>

