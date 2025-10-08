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


function getAllAdmins($conn) {
    $sql = "
        SELECT a.admin_id, a.first_name, a.last_name, a.email, a.phone_num, a.a_image
        FROM admins a
    ";
    $result = mysqli_query($conn, $sql);

    $admins = [];
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $admins[] = $row;
        }
    }
    return $admins;
}

function addAdmin($conn, $admin_id, $first_name, $last_name, $email, $phone_num, $password) {
    // Escape inputs to avoid SQL injection
    $admin_id = mysqli_real_escape_string($conn, $admin_id);
    $first_name = mysqli_real_escape_string($conn, $first_name);
    $last_name = mysqli_real_escape_string($conn, $last_name);
    $email = mysqli_real_escape_string($conn, $email);
    $phone_num = mysqli_real_escape_string($conn, $phone_num);
    $password = mysqli_real_escape_string($conn, $password); // Should be hashed for security

    // Check if email exists
    $check_email_sql = "SELECT * FROM admins WHERE email='$email'";
    $result_email = mysqli_query($conn, $check_email_sql);
    if (mysqli_num_rows($result_email) > 0) {
        echo "<script>alert('Email already exists.');</script>";
        return false;
    }

    // Insert admin data into database
    $insert_sql = "INSERT INTO admins (admin_id, first_name, last_name, email, phone_num, password)
                   VALUES ('$admin_id', '$first_name', '$last_name', '$email', '$phone_num', '$password')";

    if (mysqli_query($conn, $insert_sql)) {
        return true;
    } else {
        echo "Error: " . $insert_sql . "<br>" . mysqli_error($conn);
        return false;
    }
}

// Handle admin addition form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_admin'])) {
    $admin_id = $_POST['admin_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_num = $_POST['phone_num'];
    $password = $_POST['password']; // Ideally, use proper password hashing

    if (addAdmin($conn, $admin_id, $first_name, $last_name, $email, $phone_num, $password)) {
        echo "<script>alert('Admin added successfully.'); window.location.href='admin_admininfo.php';</script>";
    }
}

// Handle admin deletion
if (isset($_GET['delete_admin'])) {
    $admin_id = $_GET['delete_admin'];

    $delete_sql = "DELETE FROM admins WHERE admin_id = '$admin_id'";
    if (mysqli_query($conn, $delete_sql)) {
        echo "<script>alert('Admin deleted successfully.'); window.location.href='admin_admininfo.php';</script>";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
}

$admins = getAllAdmins($conn);
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


.table-image {
    width: 50px;
    height: 50px;
    border-radius: 50%;
}

.add-admin-button {
    text-align: center;
    margin-bottom: 20px;
}

.add-admin-link {
    display: inline-block;
    padding: 10px 20px;
    background-color: #4CAF50;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.add-admin-link:hover {
    background-color: #45a049;
}
.delete-icon {
    width: 40px;
    height: 40px; 
    cursor: pointer; 
    transform: translateX(10px);
    filter: brightness(0) invert(1);
    transition: filter 0.3s ease;
}

.delete-icon:hover {
    filter: brightness(0) invert(1);
    box-shadow: 0 0 10px rgba(255, 0, 0, 0.7);
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
    padding: 50px 550px;
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
        
            <h1><b>ALL ADMINS INFORMATION</b></h1>
            <div class="add-admin-button">
                <a href="admin_addadmin.php" class="add-admin-link">Add New Admin</a>
            </div>
            <div class="container2">

            <table>
                <thead>
                    <tr>
                        <th>Admin ID</th> <!-- Added admin_id column header -->
                        <th>Image</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Phone Number(+60)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($admins as $admin): ?>
                        <tr>
                            <td><?php echo $admin['admin_id']; ?></td> <!-- Display admin_id -->
                            <td><img src="<?php echo isset($admin['a_image']) && $admin['a_image'] != '' ? $admin['a_image'] : 'images/profile.png'; ?>" alt="Admin Image" class="table-image"></td>
                            <td><?php echo $admin['first_name']; ?></td>
                            <td><?php echo $admin['last_name']; ?></td>
                            <td><?php echo $admin['email']; ?></td>
                            <td><?php echo $admin['phone_num']; ?></td>
                            <td>
                                <a href="admin_admininfo.php?delete_admin=<?php echo $admin['admin_id']; ?>" class="delete-link" onclick="return confirm('Are you sure you want to delete this admin?')">
                                    <img src="images/dustbin.png" alt="Delete" class="delete-icon">
                                </a>
                            </td>
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

