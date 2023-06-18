<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'capstone';

try {
    // Attempt to connect to the database
    $conn = mysqli_connect($host, $username, $password, $database);

    // Check if the connection was successful
    if (mysqli_connect_errno()) {
        throw new Exception('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
} catch (Exception $e) {
    // Connection error occurred
    echo 'Error: ' . $e->getMessage();
}
?>