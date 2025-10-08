<?php
session_start();

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: main.php");
    exit();
}

// Get user_id from session
$user_id = $_SESSION['user_id'];

// Include database connection
include 'db_connect.php';

// Function to fetch user's profile image
$sql_profile = "SELECT u_image FROM users WHERE user_id = ?";
$stmt_profile = $conn->prepare($sql_profile);
$stmt_profile->bind_param("s", $user_id);
$stmt_profile->execute();
$stmt_profile->bind_result($u_image);
$stmt_profile->fetch();
$stmt_profile->close();

// Set default image if u_image is empty
$default_image = 'images/profile.png';
$image_to_display = !empty($u_image) ? htmlspecialchars($u_image) : $default_image;

// Function to fetch and display reservations
function fetchUpcomingReservations($conn, $user_id) {
    $sql = "SELECT r.id, r.date, v.name AS venue_name, t.time_slots AS time_slot, r.purpose, rs.status_name
            FROM reservations r
            JOIN venues v ON r.venue_id = v.id
            JOIN time_slots t ON r.slot_id = t.slot_id
            JOIN reservation_statuses rs ON r.status_id = rs.id
            WHERE r.user_id = ?
            AND r.date >= CURDATE()
            ORDER BY r.date ASC";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "SQL prepare error: " . $conn->error;
        return;
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("s", $user_id); // Changed bind_param to "s" for string
    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        echo "Query execution error: " . $stmt->error;
        return;
    }

    // Check if there are any reservations matching the user_id
    if ($result->num_rows > 0) {
        // Fetching and displaying reservation data
        while ($row = $result->fetch_assoc()) {
            echo '<div class="reservation-card">';
            echo '<h2>Reservation ID: ' . htmlspecialchars($row['id']) . '</h2>';
            echo '<p>Date: ' . htmlspecialchars($row['date']) . '</p>';
            echo '<p>Venue Name: ' . htmlspecialchars($row['venue_name']) . '</p>';
            echo '<p>Time Slot: ' . htmlspecialchars($row['time_slot']) . ':00</p>';
            echo '<p>Purpose: ' . htmlspecialchars($row['purpose']) . '</p>';
            echo '<p>Status: ' . htmlspecialchars($row['status_name']) . '</p>';
            echo '<button class="cancel-button" onclick="cancelReservation(' . htmlspecialchars($row['id']) . ')">Cancel Reservation</button>';
            echo '</div>';
        }
    } else {
        echo '<p style="color:white;">No upcoming reservations found.</p>';
    }

    // Close the statement and database connection
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University Venue Management System</title>
  <link rel="stylesheet" href="upcoming_reservation.css">
  <link rel="stylesheet" href="navi_bar_white.css">
</head>
<style>
    body{
    background-size: cover; 
    background-position: center; 
    background-repeat: no-repeat; 
    background-image: url('images/Wallpaper2.jpg');
    background-attachment: fixed;
    font-family: 'Montserrat', Arial, sans-serif;
    margin: 0;
    padding: 0;
    font-size: 20px;
    text-align: justify;
  }
</style>
<body>
<div class="container">
    <div class="profile-icon" onclick="window.location.href='profile.php'">
        <img src="<?php echo htmlspecialchars($image_to_display); ?>" alt="Profile Image">
    </div>
    <nav class="mynav">
      <ul>
        <li><a href="user_home.php">Home</a></li>
        <li class="dropdown">
          <a href="#">Reservation</a>
          <ul class="dropdown-content">
            <li><a href="reservation.php">Book Venue</a></li>
            <li><a href="past_reservation.php">Past Reservation</a></li>
            <li><a href="upcoming_reservation.php">Upcoming Reservation</a></li>
          </ul>
        </li>
        <li><a href="logout.php">Log Out</a></li>
      </ul>
    </nav>
    <span class="target"></span>

    <h1><b>UPCOMING RESERVATIONS</b></h1>
    <div class="reservation-cards">
      <?php
      fetchUpcomingReservations($conn, $user_id);
      $conn->close();
      ?>
    </div>
</div>

<script src="navi_bar.js"></script>
<script>
function cancelReservation(reservationId) {
    if (confirm("Are you sure you want to cancel this reservation?")) {
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "cancel_reservation.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert(xhr.responseText);
                location.reload(); // Reload the page to reflect the changes
            }
        };
        xhr.send("reservation_id=" + reservationId);
    }
}
</script>
</body>
</html>
