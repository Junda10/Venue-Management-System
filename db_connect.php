<?php
// Pulling from Render Environment Variables
$servername = getenv('DB_HOST') ?: "gateway01.ap-southeast-1.prod.aws.tidbcloud.com";
$username   = getenv('DB_USER') ?: "2Wx2wbVAkH3XTSW.root";
$password   = getenv('DB_PASSWORD') ?: "twPGk6WT3jGIaIvl";
$dbname     = getenv('DB_NAME') ?: "test"; 
$port       = getenv('DB_PORT') ?: 4000;

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn = mysqli_init();

    // Force SSL initialization
    // Passing NULL for all parameters tells PHP: "Use the server's default CA certs"
    mysqli_ssl_set($conn, NULL, NULL, NULL, NULL, NULL);

    // The key is the 'MYSQLI_CLIENT_SSL' flag at the end
    $success = mysqli_real_connect(
        $conn, 
        $servername, 
        $username, 
        $password, 
        $dbname, 
        $port, 
        NULL, 
        MYSQLI_CLIENT_SSL
    );

    if (!$success) {
        throw new Exception("Connection failed: " . mysqli_connect_error());
    }

    // Success! 
} catch (Exception $e) {
    error_log($e->getMessage());
    die("Error: " . $e->getMessage());
}
?>