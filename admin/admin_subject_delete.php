<?php
include('dbcon.php');
include('session.php');

$id = $_POST['selector'];
$N = count($id);
$successCount = 0;

for ($i = 0; $i < $N; $i++) {
    $subjectId = $id[$i];
    $result = mysqli_query($conn, "DELETE FROM subject WHERE subject_id='$subjectId'");
    if ($result) {
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
