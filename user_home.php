<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University Venue Management System</title>
  <link rel="stylesheet" href="uh.css">
  <link rel="stylesheet" href="navi_bar_white.css">
</head>
<body>

<?php
include 'db_connect.php'; 

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: main.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT u_image FROM users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->bind_result($u_image);
$stmt->fetch();
$stmt->close();
$conn->close();

$default_image = 'images/profile.png';

$image_to_display = !empty($u_image) ? htmlspecialchars($u_image) : $default_image;
?>

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
            <li><a href="past_reservation.php">Past Reservations</a></li>
            <li><a href="upcoming_reservation.php">Upcoming Reservations</a></li>
          </ul>
        </li>
        <li><a href="logout.php">Log Out</a></li>
      </ul>
    </nav>
</div>
    <span class="target"></span>

  <div class="table_center">
    <a href="reservation.php" >Reserve Venue Now</a>
</div>

<div class="center-image">
  <img src="images/venuemanagement.png" alt="Centered Image">
</div>
    

    <div class="confetti">
      <div class="confetti-piece"></div>
      <div class="confetti-piece"></div>
      <div class="confetti-piece"></div>
      <div class="confetti-piece"></div>
      <div class="confetti-piece"></div>
      <div class="confetti-piece"></div>
      <div class="confetti-piece"></div>
      <div class="confetti-piece"></div>
      <div class="confetti-piece"></div>
      <div class="confetti-piece"></div>
    </div>
  </div>

  <script src="navi_bar.js"></script>
</body>
</html>