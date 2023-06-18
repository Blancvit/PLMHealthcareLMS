<?php
include('dbcon.php'); // Include your database connection file
include('session.php');

$get_id = $_GET['id'];
// Retrieve the form data
$quizTitle = $_POST['quiz_title'];
$description = $_POST['description'];

// Prepare the SQL query
$query = "UPDATE quiz SET quiz_title = '$quizTitle', quiz_description = '$description' WHERE quiz_id = '$get_id'";

// Execute the query
if (mysqli_query($conn, $query)) {
    echo "success";
} else {
    echo "error: " . mysqli_error($conn);
}
