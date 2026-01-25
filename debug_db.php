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
    mysqli_report(MYSQLI_REPORT_OFF);
    $conn = mysqli_init();
    if (!$conn) {
        throw new Exception("mysqli_init failed");
    }

    $flags = 0;
    if (strpos($servername, 'tidbcloud.com') !== false) {
        $ca_path = "/etc/ssl/certs/ca-certificates.crt";
        mysqli_ssl_set($conn, NULL, NULL, $ca_path, NULL, NULL);
        $flags = MYSQLI_CLIENT_SSL;
    }

    if (!@mysqli_real_connect($conn, $servername, $username, $password, $dbname, $port, NULL, $flags)) {
        throw new Exception(mysqli_connect_error());
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

            // 4. Verify User Data
            echo "<h2>4. User Data Check (IDs only)</h2>";
            $user_check = $conn->query("SELECT user_id, email FROM users LIMIT 5");
            if ($user_check && $user_check->num_rows > 0) {
                echo "First 5 users found:<ul>";
                while ($u = $user_check->fetch_assoc()) {
                    echo "<li>ID: <code>" . $u['user_id'] . "</code> (Email: " . $u['email'] . ")</li>";
                }
                echo "</ul>";
            } else {
                echo "<p style='color:red'>⚠️ No users found in 'users' table. Data might be missing!</p>";
            }
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