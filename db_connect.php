<?php
$servername = getenv('DB_HOST') ?: "localhost";
$username = getenv('DB_USER') ?: "root";
$password = getenv('DB_PASSWORD') ?: "";
$dbname = getenv('DB_NAME') ?: "venue_management";
$port = getenv('DB_PORT') ?: 3306;

// Create connection
try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn = mysqli_init();
    if (!$conn) {
        throw new Exception("mysqli_init failed");
    }

    // TiDB Cloud (TiDB Serverless) requires SSL
    if (strpos($servername, 'tidbcloud.com') !== false) {
        // Standard CA bundle path on Render (Debian based images)
        $ca_path = "/etc/ssl/certs/ca-certificates.crt";
        mysqli_ssl_set($conn, NULL, NULL, $ca_path, NULL, NULL);
        $flags = MYSQLI_CLIENT_SSL;
    } else {
        $flags = 0;
    }

    if (!mysqli_real_connect($conn, $servername, $username, $password, $dbname, $port, NULL, $flags)) {
        throw new Exception(mysqli_connect_error());
    }
} catch (Exception $e) {
    error_log("Connection failed: " . $e->getMessage());
    die("Service temporarily unavailable. Please try again later.");
}
?>