<?php
session_start();

// Clear all session variables
$_SESSION = array();

// Destroy the session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

if (session_destroy()) {
    // Successful logout message using JavaScript
    echo '<script>alert("Logout successful."); window.location.href = "main.php";</script>';
    exit; // Make sure to exit after the JavaScript redirect
} else {
    // Handle logout failure if needed
    echo '<script>alert("Logout failed."); window.location.href = "main.php";</script>';
    exit; // Ensure to exit after the JavaScript redirect
}
?>
