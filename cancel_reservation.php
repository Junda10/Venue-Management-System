<?php
session_start();

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: main.php");
    exit();
}

// Include database connection
include 'db_connect.php';

// Check if reservation ID is set
if (isset($_POST['reservation_id'])) {
    $reservation_id = $_POST['reservation_id'];

    // Prepare the SQL statement to delete the reservation
    $sql = "DELETE FROM reservations WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("ii", $reservation_id, $_SESSION['user_id']); // changed "is" to "ii"
    if ($stmt->execute()) {
        echo "Reservation cancelled successfully.";
    } else {
        echo "Error cancelling reservation: " . htmlspecialchars($stmt->error);
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
} else {
    echo "No reservation ID provided.";
}
?>
