<?php
include 'db_connect.php'; 

session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: main.php');
    exit();
}

$sql_profile = "SELECT a_image FROM admins WHERE admin_id = ?";
$stmt_profile = $conn->prepare($sql_profile);
$stmt_profile->bind_param("s", $_SESSION['admin_id']);
$stmt_profile->execute();
$stmt_profile->bind_result($a_image);
$stmt_profile->fetch();
$stmt_profile->close();

$default_image = 'images/profile.png';
$image_to_display = !empty($a_image) ? htmlspecialchars($a_image) : $default_image;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="navi_bar_white.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap');


body {
    display: flex;
    flex-direction: column;
    min-height: 60vh;
    background-image: url('images/Wallpaper2.jpg');
    background-size: cover; 
    background-position: center; 
    background-repeat: no-repeat; 
    font-size: 20px;
    background-attachment: fixed;
}
.container{
    padding: 50px 20px;
    position: relative;
    font-family: 'Montserrat', Arial, sans-serif;
}

</style>
</head>

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
        <div class="container-reservation-menu">
        <ul class="honeycomb">
            <li class="honeycomb-cell" onclick="location.href='admin_display_reservation.php'">
                <div class="honeycomb-cell_title">Approved and Rejected Reservations</div>
            </li>
            <li class="honeycomb-cell" onclick="location.href='admin_reservation_report.php'">
                <div class="honeycomb-cell_title">Reported Reservation</div>
            </li>
            <li class="honeycomb-cell" onclick="location.href='admin_application_review.php'">
                <div class="honeycomb-cell_title">Pending Reservation</div>
            </li>
        </ul>
        </div>
        <button class="Back_Rmenu" style="padding-bottom:10px; display: block; margin: 0 auto; margin-top: 50px;" onclick="location.href='admin_mainmenu.php'">Back to Admin Main Menu</button>

    <script src="navi_bar.js"></script>
</body>

</html>
