<?php
// debug_db.php - Tool to debug database connections on Render
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>System Diagnostic Script</h1>";

// 1. Check Environment Variables
echo "<h2>1. Environment Variables</h2>";
$vars = [
    'DB_HOST' => getenv('DB_HOST'),
    'DB_USER' => getenv('DB_USER'),
    'DB_NAME' => getenv('DB_NAME'),
    'DB_PORT' => getenv('DB_PORT'),
    'DB_PASSWORD' => getenv('DB_PASSWORD') ? '****** (Set)' : 'Not Set'
];

foreach ($vars as $name => $value) {
    if ($name !== 'DB_PASSWORD') {
        echo "<strong>$name:</strong> " . ($value ?: '<span style="color:orange">Not Set (using fallback)</span>') . "<br>";
    } else {
        echo "<strong>$name:</strong> $value<br>";
    }
}

// 2. Connection Details
$servername = getenv('DB_HOST') ?: "localhost";
$username = getenv('DB_USER') ?: "root";
$password = getenv('DB_PASSWORD') ?: "";
$dbname = getenv('DB_NAME') ?: "venue_management";
$port = getenv('DB_PORT') ?: 3306;

echo "<h2>2. Attempting Connection</h2>";
echo "Attempting to connect to <code>$servername</code> on port <code>$port</code> as <code>$username</code>...<br>";

try {
    mysqli_report(MYSQLI_REPORT_OFF); // Traditional error handling for this script
    $conn = new mysqli($servername, $username, $password, $dbname, $port);

    if ($conn->connect_error) {
        throw new Exception($conn->connect_error);
    }

    echo "<p style='color:green; font-weight:bold;'>✅ Connection Successful!</p>";
    echo "Connected to: " . $conn->host_info . "<br>";

    // 3. Check Tables
    echo "<h2>3. Table Check</h2>";
    $result = $conn->query("SHOW TABLES");
    if ($result) {
        if ($result->num_rows > 0) {
            echo "Tables found in <code>$dbname</code>:<ul>";
            while ($row = $result->fetch_array()) {
                echo "<li>" . $row[0] . "</li>";
            }
            echo "</ul>";
        } else {
            echo "<p style='color:red'>⚠️ No tables found in the database. Did you run the import?</p>";
        }
    } else {
        echo "<p style='color:red'>❌ Error listing tables: " . $conn->error . "</p>";
    }

} catch (Exception $e) {
    echo "<p style='color:red; font-weight:bold;'>❌ Connection Failed!</p>";
    echo "<strong>Error Message:</strong> " . $e->getMessage() . "<br>";

    echo "<h3>Common Fixes:</h3>";
    echo "<ul>";
    echo "<li><strong>On Render:</strong> Go to Dashboard > Environment and ensure all DB_* variables are set correctly.</li>";
    echo "<li><strong>TiDB Cloud:</strong> Ensure your IP is whitelisted and if SSL is required.</li>";
    echo "<li><strong>Local:</strong> Ensure your MySQL server is running and the credentials match.</li>";
    echo "</ul>";
}
?>