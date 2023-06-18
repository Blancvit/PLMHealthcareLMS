<?php
// Start session
session_start();

// Check if the session variable 'id' is not set or empty
if (empty($_SESSION['id'])) {
    // Redirect to the login page
    header("Location: index.php");
    exit();
}

// Retrieve the session ID
$session_id = $_SESSION['id'];
