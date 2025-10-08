<?php
session_start();
include 'db_connect.php'; // Assuming this file contains your database connection

// Update reservation status
if (isset($_POST['update_status'])) {
    $reservation_id = $_POST['reservation_id'];
    $new_status = $_POST['status'];

    $sql = "UPDATE reservations SET status_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $new_status, $reservation_id);

    if ($stmt->execute()) {
        echo "<script>alert('Status updated successfully.');</script>";
    } else {
        echo "<script>alert('Error updating status: " . $conn->error . "');</script>";
    }

    $stmt->close();
}

// Fetch reservations with approved or rejected statuses
$sql = "SELECT r.id, r.venue_name, r.date, t.time_slots, r.purpose, rs.status_name
        FROM reservations r 
        JOIN time_slots t ON r.slot_id = t.slot_id 
        JOIN reservation_statuses rs ON r.status_id = rs.id 
        WHERE r.status_id IN (2, 3)"; // 2 for approved, 3 for rejected
$sql_profile = "SELECT a_image FROM admins WHERE admin_id = ?";
$stmt_profile = $conn->prepare($sql_profile);
$stmt_profile->bind_param("s", $_SESSION['admin_id']);
$stmt_profile->execute();
$stmt_profile->bind_result($a_image);
$stmt_profile->fetch();
$stmt_profile->close();

// Set default image if u_image is empty
$default_image = 'images/profile.png';
$image_to_display = !empty($a_image) ? htmlspecialchars($a_image) : $default_image;
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University Venue Management System</title>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    margin: 0;
    padding: 0;
    font-size: 20px;
    text-align: justify;
  }

  .container{
    padding: 50px 550px;
    position: relative;
    font-family: 'Montserrat', Arial, sans-serif;
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
</style>
<body>
    
<div class="container">
    <div class="profile-icon" onclick="window.location.href='admin_profile.php'">
        <img src="<?php echo htmlspecialchars($image_to_display); ?>" alt="Profile Image">
    </div>
    <nav class="mynav">
      <ul>
        <li><a href="admin_mainmenu.php">Main Menu</a></li>
        <li><a href="logout.php">Log Out</a></li>
      </ul>
    </nav>
</div>
    <span class="target"></span>

        <h1><b>APPROVED & REJECTED RESERVATIONS</b></h1>
        <div class="container2">
        <table>
            <tr>
                <th>ID</th>
                <th>Venue Name</th>
                <th>Date</th>
                <th>Time Slot</th>
                <th>Purpose</th>
                <th>Status</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['id'] . "</td>";
                    echo "<td>" . $row['venue_name'] . "</td>";
                    echo "<td>" . $row['date'] . "</td>";
                    echo "<td>" . $row['time_slots'] . "</td>";
                    echo "<td>" . $row['purpose'] . "</td>";
                    echo "<td>" . $row['status_name'] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No approved or rejected reservations found.</td></tr>";
            }
            ?>
        </table>
    </div>
    <button class="Back_Rmenu" style="padding-bottom:10px;" onclick="location.href='admin_reservation_menu.php'">Back to Reservation Menu</button>
    <script src="navi_bar.js"></script>
</body>
</html>

<?php
$conn->close();
?>

