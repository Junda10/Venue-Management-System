<?php
session_start();

// Database connection
include 'db_connect.php';

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

* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    display: flex;
    flex-direction: column;
    min-height: 60vh;
    font-family: 'Roboto', Arial;
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
.container-reservation-menu {
    flex: 1;
    display: flex;
    justify-content: center; 
    align-items: center; 
    padding: 50px 20px;
    background: transparent;
}

.honeycomb {
    display: flex;
    justify-content: center;
    align-items: center;
    max-width: 100%;
    padding: 0;
    list-style: none;
    gap: 20px; 
}

.honeycomb-cell {
    width: 250px;
    height: 137.5px;
    position: relative;
    padding: 1em;
    text-align: center;
    z-index: 1;
    box-shadow: 0 0 30px 10px rgba(100, 100, 255, .6);
    background-color: #ccf;
    opacity: 0.50;
    background-blend-mode: color-burn;
    transition: all 0.3s ease;
    cursor: pointer;
}


.honeycomb-cell:hover {
    box-shadow: 0px 0px 15px 0 rgba(0, 0, 0, 0.1);
    background-color: #ccf;
    opacity: 1;
}

.honeycomb-cell::before,
.honeycomb-cell::after {
    content: '';
    top: -50%;
    left: 0;
    width: 100%;
    height: 200%;
    display: block;
    position: absolute;
    clip-path: polygon(50% 0%, 100% 25%, 100% 75%, 50% 100%, 0% 75%, 0% 25%);
    z-index: -1;
}

.honeycomb-cell::before {
    background: #fff;
    transform: scale(1.055);
}

.honeycomb-cell::after {
    background-color: #58d;
    transition: opacity 0.3s ease-in-out;
}

.honeycomb-cell_title {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    color: #fff;
    font-weight: 700;
    font-size: 1.75em;
    transition: opacity 0.3s ease-in-out;
}

.profile-icon {
    position: absolute;
    left: 70px;
    top: 30px;
    width: 50px;
    height: 50px;
    background-size: cover;
    cursor: pointer;
}
.profile-icon img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
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
        <li class="honeycomb-cell" onclick="location.href='admin_admininfo.php'">
            <div class="honeycomb-cell_title">Admin Info</div>
        </li>
        <li class="honeycomb-cell" onclick="location.href='admin_userinfo.php'">
            <div class="honeycomb-cell_title">User Info</div>
        </li>
    </ul>
</div>
    <button class="Back_Rmenu" style="padding-bottom:10px; display: block; margin: 0 auto; margin-top: 150px;" onclick="location.href='admin_mainmenu.php'">Back to Admin Main Menu</button>
    <script src="navi_bar.js"></script>

</body>

</html>
