<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: main.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Include database connection
include 'db_connect.php';

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

// Function to fetch and display past reservations for the logged-in user
function fetchPastReservations($conn, $user_id) {
    $sql = "SELECT r.id, r.date, v.name AS venue_name, t.time_slots AS time_slot, r.purpose
            FROM reservations r
            JOIN venues v ON r.venue_id = v.id
            JOIN time_slots t ON r.slot_id = t.slot_id
            WHERE r.user_id = ?
            AND r.date < CURDATE()
            ORDER BY r.date DESC";

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "SQL prepare error: " . $conn->error;
        return;
    }

    // Bind parameters and execute the statement
    $stmt->bind_param("i", $user_id); // Changed bind_param to "i" for integer
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
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['id']) . '</td>';
            echo '<td>' . htmlspecialchars($row['date']) . '</td>';
            echo '<td>' . htmlspecialchars($row['venue_name']) . '</td>';
            echo '<td>' . htmlspecialchars($row['time_slot']) . '</td>';
            echo '<td>' . htmlspecialchars($row['purpose']) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="5">No past reservations found.</td></tr>';
    }

    // Close the statement
    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University Venue Management System</title>
  <link rel="stylesheet" href="navi_bar_white.css">
  <link rel="stylesheet" href="aa_review.css">
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
  .profile-icon {
  position: absolute;
  left:0px; 
  top: 30px; 
  width: 50px;
  height: 50px;
  background-size: cover;
  z-index: 10; 
}

.profile-icon img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 50%;
}
.container{
    padding: 50px 500px;
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
          <a href="#">Reservations</a>
          <ul class="dropdown-content">
            <li><a href="reservation.php">Book Venues</a></li>
            <li><a href="past_reservation.php">Past Reservations</a></li>
            <li><a href="upcoming_reservation.php">Upcoming Reservations</a></li>
          </ul>
        </li>
        <li><a href="logout.php">Log Out</a></li>
      </ul>
    </nav>
    </div>
    <span class="target"></span>


    <h1><b>PAST RESERVATIONS</b></h1>
    <div >
      <table>
        <thead>
          <tr>
            <th>Reservation ID</th>
            <th>Date</th>
            <th>Venue Name</th>
            <th>Time Slot</th>
            <th>Purpose</th>
          </tr>
        </thead>
        <tbody>
          <?php
          fetchPastReservations($conn, $user_id);
          $conn->close();
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <script src="navi_bar.js"></script>
</body>
</html>
