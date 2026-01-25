<?php
$servername = getenv('DB_HOST') ?: "localhost";
$username = getenv('DB_USER') ?: "root";
$password = getenv('DB_PASSWORD') ?: "";
$dbname = getenv('DB_NAME') ?: "venue_management";
$port = getenv('DB_PORT') ?: 3306;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    // On live production, do not echo the exact error to the user
    // die("Connection failed: " . $conn->connect_error); 
    error_log("Connection failed: " . $conn->connect_error);
    die("Service temporarily unavailable. Please try again later.");
}
?>