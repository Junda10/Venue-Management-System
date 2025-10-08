<?php
session_start();
include 'db_connect.php';

$sql_profile = "SELECT u_image FROM users WHERE user_id = ?";
$stmt_profile = $conn->prepare($sql_profile);
$stmt_profile->bind_param("s", $_SESSION['user_id']);
$stmt_profile->execute();
$stmt_profile->bind_result($u_image);
$stmt_profile->fetch();
$stmt_profile->close();

// Set default image if u_image is empty
$default_image = 'images/profile.png';
$image_to_display = !empty($u_image) ? htmlspecialchars($u_image) : $default_image;

$reservation_success = isset($_SESSION['reservation_success']) ? $_SESSION['reservation_success'] : false;

unset($_SESSION['reservation_success']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University Venue Management System</title>
  <link rel="stylesheet" href="navi_bar_white.css">
</head>
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

    <div class="confirmation-Container">
    <div class="confirmation-container">
      <div class="icon">✔</div>
      <h1>Reservation Successful!</h1>
      <p>Your reservation has been successfully made. Please wait for verification.</p>
      <a href="user_home.php" class="back-button">Back to Main Page</a>
    </div>
</div>
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

      <script src="navi_bar.js"></script>
</body>
</html>

<style>
    *{
      box-sizing: border-box;
    }

    body{
      background-color: black;
      background-image: url('images/Wallpaper2.jpg');
      background-size: cover; 
      background-position: center; 
      background-repeat: no-repeat; 
      font-family: 'Montserrat', Arial, sans-serif;
      margin: 0;
      padding: 0;
      font-size: 20px;
      text-align: justify;
    }

    .popup-message{
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      padding: 20px;
      padding-top: 80px;
      background-color: #333;
      color: white;
      border-radius: 10px;
      text-align: center;
    }

    .popup-message button{
      margin-top: 10px;
      padding: 5px 10px;
      background-color: #555;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
    }

    .confirmation-Container {
  display: flex;
  justify-content: center; /* Center horizontally */
  align-items: center; /* Center vertically */
  height: 80vh; /* Make sure it takes up the full viewport height */
}

.confirmation-container {
  background: white;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  padding: 40px;
  max-width: 500px;
  width: 100%;
  text-align: center;
  color: #333;
}


    .confirmation-container .icon{
      font-size: 50px;
      color: #28a745;
      margin-bottom: 20px;
    }

    .confirmation-container h1{
      font-size: 24px;
      margin-bottom: 10px;
    }

    .confirmation-container p{
      font-size: 16px;
      color: #666;
    }

    .confirmation-container .back-button{
      display: inline-block;
      margin-top: 20px;
      padding: 10px 20px;
      background-color: #28a745;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      transition: background-color 0.3s;
    }

    .confirmation-container .back-button:hover{
      background-color: #218838;
    }

    .confetti{
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
      z-index: -1;
      overflow: hidden;
    }

    .confetti-piece{
      position: absolute;
      width: 10px;
      height: 10px;
      background: white;
      animation: confetti 5s linear infinite;
      opacity: 0;
    }

    @keyframes confetti{
      0% {
        transform: translateY(0) rotate(0deg);
        opacity: 1;
      }
      100% {
        transform: translateY(100vh) rotate(360deg);
        opacity: 0;
      }
    }

    .profile-icon {
  position: absolute;
  left: 70px;
  top: 30px;
  width: 50px;
  height: 50px;
  background-image: url('images/profile2.png');
  background-size: cover;
  cursor: pointer;
}

.profile-icon img {
  width: 100%; /* Ensure the image covers the container */
  height: 100%; /* Ensure the image covers the container */
  object-fit: cover; /* Ensure the image maintains aspect ratio and covers the container */
  border-radius: 50%; /* Ensure the image is also circular */
}

    .confetti-piece:nth-child(1) { left: 10%; animation-delay: 0s; }
    .confetti-piece:nth-child(2) { left: 20%; animation-delay: 1s; }
    .confetti-piece:nth-child(3) { left: 30%; animation-delay: 2s; }
    .confetti-piece:nth-child(4) { left: 40%; animation-delay: 3s; }
    .confetti-piece:nth-child(5) { left: 50%; animation-delay: 4s; }
    .confetti-piece:nth-child(6) { left: 60%; animation-delay: 5s; }
    .confetti-piece:nth-child(7) { left: 70%; animation-delay: 6s; }
    .confetti-piece:nth-child(8) { left: 80%; animation-delay: 7s; }
    .confetti-piece:nth-child(9) { left: 90%; animation-delay: 8s; }
    .confetti-piece:nth-child(10) { left: 100%; animation-delay: 9s; }
    .confetti-piece:nth-child(10) { left: 100%; animation-delay: 9s; }

</style>