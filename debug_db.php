<?php
// debug_db.php - Tool to debug database connections on Render
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>System Diagnostic Script</h1>";

// 1. Check Environment Variables
echo "<h2>1. Environment Variables</h2>";
echo "Host: " . (getenv('DB_HOST') ?: 'Not Set (using fallback)') . "<br>";
echo "User: " . (getenv('DB_USER') ?: 'Not Set (using fallback)') . "<br>";
echo "DB Name: " . (getenv('DB_NAME') ?: 'Not Set (using fallback)') . "<br>";
echo "Port: " . (getenv('DB_PORT') ?: 'Not Set (using fallback)') . "<br>";

// 2. Attempt Connection
echo "<h2>2. Database Connection Test</h2>";
require 'db_connect.php'; // Using your existing wrapper

if ($conn->connect_error) {
    echo "<p style='color:red'>❌ Connection Failed: " . $conn->connect_error . "</p>";
} else {
    echo "<p style='color:green'>✅ Connection Successful!</p>";
    echo "Connected to: " . $conn->host_info . "<br>";

    // 3. Check Tables
    echo "<h2>3. Table Check</h2>";
    $result = $conn->query("SHOW TABLES");
    if ($result) {
        if ($result->num_rows > 0) {
            echo "<ul>";
            while ($row = $result->fetch_array()) {
                echo "<li>" . $row[0] . "</li>";
            }
            echo "</ul>";
            echo "<p style='color:green'>✅ Tables found. If this list is empty, you need to import your SQL file!</p>";
        } else {
            echo "<p style='color:red'>⚠️ No tables found in the database. Did you run the import?</p>";
        }
    } else {
        echo "<p style='color:red'>❌ Error listing tables: " . $conn->error . "</p>";
    }
}
?>