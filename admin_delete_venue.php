<?php
include 'db_connect.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $venue_id = $_GET['id'];
    
    $sql = "DELETE FROM venues WHERE id = $venue_id";
    
    if ($conn->query($sql) === TRUE) {
        // Show pop-up message using JavaScript
        echo '<script>alert("Venue deleted successfully");</script>';
        // Redirect back to admin_display_venue.php
        echo '<script>window.location.href = "admin_display_venue.php";</script>';
        exit; // Exit to prevent further execution
    } else {
        echo "Error deleting venue: " . $conn->error;
    }
} else {
    echo "Venue ID not specified";
}

$conn->close();
?>
