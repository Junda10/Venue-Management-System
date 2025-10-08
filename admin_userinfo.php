<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: main.php");
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

function getAllUsers($conn) {
    $sql = "
        SELECT u.user_id, u.first_name, u.last_name, u.email, u.phone_num, u.u_image,
               r.role, f.faculty_name, t.term_name
        FROM users u
        JOIN roles r ON u.role_id = r.id
        JOIN faculty_types f ON u.faculty_id = f.faculty_id
        JOIN term_types t ON u.term_id = t.term_id
    ";
    $result = mysqli_query($conn, $sql);

    $users = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }
    return $users;
}

$users = getAllUsers($conn);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Venue Management System</title>
    <link rel="stylesheet" href="aa_review.css">
    <link rel="stylesheet" href="navi_bar_white.css">

    <style>
body {
    background-color: black;
    background-image: url('images/Wallpaper2.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
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

.table-image {
    width: 50px;
    height: 50px;
    border-radius: 50%;
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
    <h1><b>ALL USERS INFORMATION</b></h1>

        <div class="container2">
            <table>
            <thead>
                <tr>
                    <th>User ID</th> 
                    <th>Image</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone Number(+60)</th>
                    <th>Role</th>
                    <th>Faculty</th>
                    <th>Term</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['user_id']; ?></td> <!-- Display user_id -->
                        <td><img src="<?php echo isset($user['u_image']) && $user['u_image'] != '' ? $user['u_image'] : 'images/profile.png'; ?>" alt="User Image" class="table-image"></td>
                        <td><?php echo $user['first_name']; ?></td>
                        <td><?php echo $user['last_name']; ?></td>
                        <td><?php echo $user['email']; ?></td>
                        <td><?php echo $user['phone_num']; ?></td>
                        <td><?php echo $user['role']; ?></td>
                        <td><?php echo $user['faculty_name']; ?></td>
                        <td><?php echo $user['term_name']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>
        <button class="Back_Rmenu" style="padding-bottom:10px;" onclick="location.href='admin_system_info_menu.php'">Back to Info Menu</button>

    </div>
    
    <script src="navi_bar.js"></script>
</body>
</html>

