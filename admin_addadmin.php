<?php
session_start();
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $adminId = $_POST['admin_id'];
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phoneNum = $_POST['phone_num'];
    $password = $_POST['password'];

    $sql_check_id = "SELECT COUNT(*) FROM admins WHERE admin_id = ?";
    $stmt_check_id = $conn->prepare($sql_check_id);
    $stmt_check_id->bind_param("s", $adminId);
    $stmt_check_id->execute();
    $stmt_check_id->bind_result($id_count);
    $stmt_check_id->fetch();
    $stmt_check_id->close();

    if ($id_count > 0) {
        echo "<script>alert('Admin ID already exists. Please choose a different Admin ID.');</script>";
    } else {
        // Check for duplicate email
        $sql_check_email = "SELECT COUNT(*) FROM admins WHERE email = ?";
        $stmt_check_email = $conn->prepare($sql_check_email);
        $stmt_check_email->bind_param("s", $email);
        $stmt_check_email->execute();
        $stmt_check_email->bind_result($email_count);
        $stmt_check_email->fetch();
        $stmt_check_email->close();

        if ($email_count > 0) {
            echo "<script>alert('Email already exists. Please use a different email address.');</script>";
        } else {
            // Prepare SQL insert statement
            $sql = "INSERT INTO admins (admin_id, first_name, last_name, email, phone_num, password) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss", $adminId, $firstName, $lastName, $email, $phoneNum, $password);

            // Execute SQL statement
            if ($stmt->execute()) {
                echo "<div class='message'>";
                echo "<p>Admin added successfully!</p>";
                echo "</div>";

                // Redirect to admin_admininfo.php after successful addition
                echo '<script>window.location.href = "admin_admininfo.php";</script>';
                exit;
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Venue Management System</title>
    <link rel="stylesheet" href="navi_bar_white.css">
    <style>
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    background-color: black;
    background-image: url('images/Wallpaper2.jpg');
    background-size: cover; 
    background-position: center; 
    background-repeat: no-repeat; 
    font-family: 'Montserrat', Arial, sans-serif;
    font-size: 20px;
    text-align: justify;
    color: #fff;
}

.container3 {
    max-width: 1200px;
    width: 90%;
    margin: 70px auto;
    background-color: rgba(0, 0, 0, 0.8);
    padding: 20px;
    border-radius: 10px;
}
.container{
    padding: 50px 20px;
    position: relative;
    font-family: 'Montserrat', Arial, sans-serif;
}

h1, h2 {
    text-align: center;
    color: #03e9f4;
    margin-bottom: 20px;
}

form {
    margin-top: 20px;
}

.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
}

input[type="text"],
input[type="email"],
input[type="password"],
input[type="submit"],
select {
    width: 100%;
    padding: 10px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease;
    background-color: rgba(255, 255, 255, 0.1);
    color: #fff;
}

input[type="submit"] {
    background-color: #03e9f4;
    color: white;
    margin-left: 10px;
    padding: 15px;
    font-size: 18px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

select {
    background-color: #333;
    color: #fff;
}

button[type="submit"] {
    background: linear-gradient(135deg, #03e9f4, #00bfa5);
    color: white;
    padding: 15px 50px;
    font-size: 20px;
    border-radius: 50px;
    cursor: pointer;
    transition: background 0.3s ease, transform 0.3s ease;
    border: none;
    text-transform: uppercase;
    font-weight: 700;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    position: relative;
    overflow: hidden;
}

button[type="submit"]::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 300%;
    height: 300%;
    background: rgba(255, 255, 255, 0.1);
    opacity: 0;
    transition: opacity 0.3s ease, transform 0.3s ease;
    transform: translateX(-50%) translateY(-50%) rotate(45deg);
}

button[type="submit"]:hover {
    background: linear-gradient(135deg, #00bfa5, #03e9f4);
    transform: scale(1.05);
}

button[type="submit"]:hover::before {
    opacity: 1;
    transform: translateX(0) translateY(0) rotate(45deg);
}

.message {
    background-color: #45a049;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    text-align: center;
    margin-top: 20px;
}

.error-message {
    background-color: #ff6347;
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
    <div class="container3">
        <h1>Add New Admin</h1>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data" onsubmit="return validatePasswords()">
            <div class="form-group">
                <label for="admin_id">Admin ID:</label>
                <input type="text" id="admin_id" name="admin_id" required>
            </div>
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="phone_num">Phone Number(+60):</label>
                <input type="text" id="phone_num" name="phone_num" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required minlength="8">
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required minlength="8" oninput="validatePasswordMatch()">
                <div id="password-error" class="error-message" style="display: none;">Passwords do not match!</div>
            </div>
            <button type="submit" name="add_admin" id="submitBtn">Add Admin</button>
            </form> 
        </div>
        <button class="Back_Rmenu"  style="margin-top: 20px;padding-bottom:10px; display: block; margin: 0 auto; margin-bottom: 20px;" onclick="location.href='admin_admininfo.php'">Back to Admin Info</button>
    <script>
        function validatePasswordMatch() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;
            var errorMessage = document.getElementById("password-error");

            if (password !== confirmPassword) {
                errorMessage.style.display = "block";
                document.getElementById("submitBtn").disabled = true;
            } else {
                errorMessage.style.display = "none";
                document.getElementById("submitBtn").disabled = false;
            }
        }

        function validatePasswords() {
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;

            if (password !== confirmPassword) {
                alert("Passwords do not match!");
                return false;
            }

            return true;
        }

        function validateEmail() {
            var email = document.getElementById('email').value;
            if (email.indexOf('@') === -1) {
                alert('Please enter a valid email address containing "@" symbol.');
                return false;
            }
            return true;
        }
    </script>
        <script src="navi_bar.js"></script>

</body>
</html>
