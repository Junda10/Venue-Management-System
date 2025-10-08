<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $venue_id = $_POST['venue_id'];
    $name = $_POST['name'];
    $type_id = $_POST['type_id'];
    $venue_description = $_POST['venue_description'];

    // Update the database
    $sql = "UPDATE venues SET name = ?, type_id = ?, venue_description = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sisi", $name, $type_id, $venue_description, $venue_id);

    if ($stmt->execute()) {
        // Close prepared statement
        $stmt->close();
        $conn->close();

        // Display JavaScript alert
        echo '<script>alert("Venue successfully updated!");</script>';
        
        // Redirect back to previous page (assuming you want to go back to admin_display_venue.php)
        echo '<script>window.location.href = "admin_display_venue.php";</script>';
        exit; // Ensure script stops executing after redirect
    } else {
        $_SESSION['update_error'] = "Error updating venue: " . $conn->error; // Set session variable for error message
        
        $stmt->close();
        $conn->close();
        
        echo '<script>alert("Error updating venue. Please try again.");</script>';
    }
} else {
    echo "Invalid request method.";
}
?>
