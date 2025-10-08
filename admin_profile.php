<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['admin_id'])) {
    header("Location: main.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

function getAdminDetails($conn, $admin_id) {
    $sql = "SELECT * FROM admins WHERE admin_id='$admin_id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        return mysqli_fetch_assoc($result);
    } else {
        return null;
    }
}

$row = getAdminDetails($conn, $admin_id);
if ($row) {
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $email = $row['email'];
    $phone_num = $row['phone_num'];
    $profile_image = $row['a_image'];
} else {
    echo "Admin not found.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_num = $_POST['phone_num'];

    $image_path = $profile_image; // Default to the existing image

    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] == UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["profile_image"]["tmp_name"]);
        if ($check !== false) {
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                $image_path = $target_file;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "File is not an image.";
        }
    }

    $update_sql = "UPDATE admins SET first_name='$first_name', last_name='$last_name', email='$email', phone_num='$phone_num', a_image='$image_path' WHERE admin_id='$admin_id'";

    if (mysqli_query($conn, $update_sql)) {
        $row = getAdminDetails($conn, $admin_id);
        $profile_image = $row['a_image'];
        echo "<script>alert('Profile Updated Successfully.'); window.location='admin_profile.php';</script>";
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Venue Management System</title>
    <link rel="stylesheet" href="navi_bar_white.css">

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
    .container{
    padding: 50px 20px;
    position: relative;
    font-family: 'Montserrat', Arial, sans-serif;

  }

    .profile-container{
        display: flex;
        width: 100%;
        height: 110%;
        margin-top: 50px;
        border: 3px solid #ddd; 
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .sidebar{
        margin: 0;
        font-family: sans-serif;
        background: rgba(0, 0, 0, .5);
        color: white;
        padding: 20px;
        width: 30%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .upload-container{
        margin-top: 10px;
    }

    .upload-label{
        display: inline-block;
        padding: 10px 20px;
        background-color: black;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .profile-content{
        background-color: rgba(0, 0, 0, 0.8);        
        padding: 40px;
        width: 70%;
        display: flex;
        flex-direction: column;
        text-align: center;
    }

    .profile-content h1{
        margin-bottom: 20px;
        color: white;
    }

    .form-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .form-group {
        width: 100%;
        margin-bottom: 20px;
    }

    .form-group label {
        color: #fff;
        margin-bottom: 10px;
    }

    .form-group input,
    .form-group select {
        width: calc(100% - 20px);
        padding: 10px;
        border: none;
        border-bottom: 1px solid #fff;
        background-color: transparent;
        color: #fff;
        margin-top: 5px;
        font-size: 16px;
        outline: none;
    }

    .profile-icon p {
        color: #fff;
    }

    .btn {
        position: relative;
        display: inline-block;
        padding: 10px 20px;
        color: #03e9f4;
        font-size: 16px;
        text-decoration: none;
        text-transform: uppercase;
        overflow: hidden;
        transition: .5s;
        margin-top: 20px;
        letter-spacing: 4px;
        border: 2px solid #03e9f4;
        background: transparent;
    }

    .btn:hover {
        background: #03e9f4;
        color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 5px #03e9f4,
                    0 0 25px #03e9f4,
                    0 0 50px #03e9f4,
                    0 0 100px #03e9f4;
    }

    .btn::before, .btn::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #03e9f4);
        animation-duration: 1s;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
    }

    .btn::before {
        top: 0;
        left: -100%;
        animation-name: btn-anim1;
    }

    .btn::after {
        bottom: 0;
        right: -100%;
        animation-name: btn-anim3;
    }

    @keyframes btn-anim1 {
        0% {
            left: -100%;
        }
        50%, 100% {
            left: 100%;
        }
    }

    @keyframes btn-anim2 {
    0% {
        top: -100%;
    }

    50%,
    100% {
        top: 100%;
    }
}

    @keyframes btn-anim3 {
        0% {
            right: -100%;
        }
        50%, 100% {
            right: 100%;
        }
    }

    @keyframes btn-anim4 {
    0% {
        bottom: -100%;
    }

    50%,
    100% {
        bottom: 100%;
    }
}
    
    .upload-label {
        position: relative;
        display: inline-block;
        padding: 10px 20px;
        color: #03e9f4;
        font-size: 16px;
        text-decoration: none;
        text-transform: uppercase;
        overflow: hidden;
        transition: .5s;
        margin-top: 20px;
        letter-spacing: 4px;
        border: 2px solid #03e9f4;
        background: transparent;
    }

    .upload-label:hover {
        background-color: #03e9f4;
        color: #fff;
        border-radius: 5px;
        box-shadow: 0 0 5px #03e9f4, 0 0 25px #03e9f4, 0 0 50px #03e9f4, 0 0 100px #03e9f4;
    }

    .upload-label::before,
    .upload-label::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 2px;
        background: linear-gradient(90deg, transparent, #03e9f4);
        animation-duration: 1s;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
    }

    .upload-label::before {
        top: 0;
        left: -100%;
        animation-name: upload-anim1;
    }

    .upload-label::after {
        bottom: 0;
        right: -100%;
        animation-name: upload-anim3;
    }

    @keyframes upload-anim1 {
        0% {
            left: -100%;
        }
        50%, 100% {
            left: 100%;
        }
    }

    @keyframes upload-anim3 {
        0% {
            right: -100%;
        }
        50%, 100% {
            right: 100%;
        }
    }

    .profile-image {
        width: 150px;
        height: 150px;
        border-radius: 50%;
        object-fit: cover;
        margin-bottom: 20px;
    }
</style>
</head>
<body>
    <div class="container">
    <div><img src="<?php echo isset($profile_image) && $profile_image != '' ? $profile_image : 'images/profile.png'; ?>" alt="Profile Image" class="profile-icon" onclick="window.location.href='admin_profile.php'"></div>    
    <nav class="mynav">
            <ul>
                <li><a href="admin_mainmenu.php">Main Menu</a></li>
                <li><a href="logout.php">Log Out</a></li>
            </ul>
        </nav>
        <span class="target"></span>
        <div class="profile-container">
            <div class="sidebar">
                <p>Admin ID: <?php echo htmlspecialchars($_SESSION['admin_id']); ?></p>
                <img src="<?php echo isset($profile_image) && $profile_image != '' ? $profile_image : 'images/profile.png'; ?>" alt="Profile Image" class="profile-image" id="output">
                <div class="upload-container">
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
                        <input type="file" accept="image/*" name="profile_image" id="file" onchange="loadFile(event)" style="display: none;"><br>
                        <label for="file" class="upload-label">Upload Image</label><br>
                </div>
            </div>
            <div class="profile-content">
                <h1>Edit Profile</h1>
                <div class="form-row">
                    <div class="form-group">
                        <label for="first_name">First Name:</label>
                        <input type="text" id="first_name" name="first_name" value="<?php echo $first_name; ?>">
                    </div>
                    <div class="form-group">
                        <label for="last_name">Last Name:</label>
                        <input type="text" id="last_name" name="last_name" value="<?php echo $last_name; ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone_num">Phone Number:</label>
                        <input type="text" id="phone_num" name="phone_num" value="<?php echo $phone_num; ?>">
                    </div>
                </div>
                <button type="submit" class="btn">Save Changes</button>
            </div>
            </form>
        </div>
    </div>
    <script>
        const target = document.querySelector(".target");
        const links = document.querySelectorAll(".mynav a");
        const colors = ["deepskyblue", "orange", "firebrick", "gold", "magenta", "white", "darkblue"];

        function mouseenterFunc() {
            if (!this.parentNode.classList.contains("active")) {
                for (let i = 0; i < links.length; i++) {
                    if (links[i].parentNode.classList.contains("active")) {
                        links[i].parentNode.classList.remove("active");
                    }
                    links[i].style.opacity = "0.25";
                }

                this.parentNode.classList.add("active");
                this.style.opacity = "1";

                const width = this.getBoundingClientRect().width;
                const height = this.getBoundingClientRect().height;
                const left = this.getBoundingClientRect().left + window.pageXOffset;
                const top = this.getBoundingClientRect().top + window.pageYOffset;
                const color = colors[Math.floor(Math.random() * colors.length)];

                target.style.width = `${width}px`;
                target.style.height = `${height}px`;
                target.style.left = `${left}px`;
                target.style.top = `${top}px`;
                target.style.borderColor = color;
                target.style.transform = "none";
            }
        }

        for (let i = 0; i < links.length; i++) {
            links[i].addEventListener("mouseenter", mouseenterFunc);
        }

        function resizeFunc() {
            const active = document.querySelector(".mynav li.active");

            if (active) {
                const left = active.getBoundingClientRect().left + window.pageXOffset;
                const top = active.getBoundingClientRect().top + window.pageYOffset;

                target.style.left = `${left}px`;
                target.style.top = `${top}px`;
            }
        }

        window.addEventListener("resize", resizeFunc);

        function loadFile(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        }
    </script>
</body>
</html>

