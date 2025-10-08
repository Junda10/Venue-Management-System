<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: main.php');
    exit();
}

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

// Retrieve venues based on category if specified
$sql_venues = "SELECT venues.id, venues.name, venues.images, venue_types.type, venue_description
               FROM venues 
               JOIN venue_types ON venues.type_id = venue_types.id";

if (isset($_GET['category']) && !empty($_GET['category'])) {
    $category_id = $_GET['category'];
    $sql_venues .= " WHERE venues.type_id = ?";
    $stmt_venues = $conn->prepare($sql_venues);
    $stmt_venues->bind_param("i", $category_id);
} else {
    $stmt_venues = $conn->prepare($sql_venues);
}

$stmt_venues->execute();
$result = $stmt_venues->get_result();
if (!$result) {
  echo "Query execution error: " . $stmt_venues->error;
  exit();
}
$stmt_venues->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University Venue Management System</title>
  <link rel="stylesheet" href="admin_display_venue.css">
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
            <li><a href="past_reservation.php">Past Reservations</a></li>
            <li><a href="upcoming_reservation.php">Upcoming Reservations</a></li>
          </ul>
        </li>
        <li><a href="logout.php">Log Out</a></li>
      </ul>
    </nav>
    <span class="target"></span>

    <div class="category-dropdown">
      <button class="dropbtn"><b>SELECT CATEGORY</b></button>
      <div class="category-dropdown-content">
        <form action="reservation.php" method="GET">
          <button type="submit" name="category" value="">ALL CATEGORY</button>
          <?php
          $sql_categories = "SELECT * FROM venue_types";
          $result_categories = $conn->query($sql_categories);
          while ($row_category = $result_categories->fetch_assoc()) {
            echo '<button type="submit" name="category" value="' . $row_category['id'] . '">' . $row_category['type'] . '</button>';
          }
          ?>
        </form>
      </div>
    </div>

    <div class="container flip-card-container">
      <?php
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo '<div class="flip-card" style="--hue: 220">
                      <div class="flip-card-inner">
                          <div class="card-front">
                              <figure>
                                  <div class="img-bg"></div>
                                  <img src="images/' . $row['images'] . '" alt="' . $row['name'] . '">
                                  <figcaption>' . $row['type'] . '</figcaption>
                              </figure>
                              <ul>
                                  <li>' . $row['name'] . '</li>
                              </ul>
                          </div>
                          <div class="card-back">
                              <figure>
                                  <div class="img-bg"></div>
                                  <img src="images/' . $row['images'] . '" alt="' . $row['name'] . '">
                              </figure>
                              <p>'.$row['venue_description'].'</p>
                              <a href="reservation_slot.php?id=' . $row['id'] . '&name=' . urlencode($row['name']) . '&images=' . urlencode($row['images']) . '&type=' . urlencode($row['type']) . '"><button>Book</button></a>
                              <div class="design-container">
                              </div>
                          </div>
                      </div>
                  </div>';
          }
      } else {
          echo "No venues available.";
      }
      $conn->close();
      ?>
    </div>
    <script src="navi_bar.js"></script>
  </body>
  </html>
