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

// Fetch venue types for dropdown
$sql_categories = "SELECT * FROM venue_types";
$result_categories = $conn->query($sql_categories);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Process form submission
    $name = $_POST['name'];
    $type_id = $_POST['type_id'];
    $venue_description = $_POST['venue_description'];

    $target_dir = "images/"; // Target directory where images will be stored
    $unique_filename = uniqid() . '_' . time() . '.' . pathinfo($_FILES["venue_image"]["name"], PATHINFO_EXTENSION);
    $target_file = $target_dir . $unique_filename; // Full path including directory

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["venue_image"]["tmp_name"]);
        if($check !== false) {
            $uploadOk = 1;
        } else {
            echo '<script>alert("File is not an image.");</script>';
            $uploadOk = 0;
        }
    }

    if (file_exists($target_file)) {
        echo '<script>alert("Sorry, file already exists.");</script>';
        $uploadOk = 0;
    }

    if ($_FILES["venue_image"]["size"] > 500000) {
        echo '<script>alert("Sorry, your file is too large.");</script>';
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo '<script>alert("Sorry, only JPG, JPEG, PNG & GIF files are allowed.");</script>';
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo '<script>alert("Sorry, your file was not uploaded.");</script>';
    } else {
        if (move_uploaded_file($_FILES["venue_image"]["tmp_name"], $target_file)) {
            $image_path = $unique_filename;

            $insert_sql = "INSERT INTO venues (name, type_id, images, venue_description) 
                           VALUES ('$name', '$type_id', '$image_path', '$venue_description')";

            if (mysqli_query($conn, $insert_sql)) {
                $_SESSION['venue_added'] = true;
                echo '<script>alert("New venue added successfully."); window.location.href = "admin_display_venue.php";</script>';
            } else {
                echo "Error: " . $insert_sql . "<br>" . mysqli_error($conn);
            }
        } else {
            echo '<script>alert("Sorry, there was an error uploading your file.");</script>';
        }
    }
}
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
.container{
    padding: 50px 20px;
    position: relative;
    font-family: 'Montserrat', Arial, sans-serif;
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

.container2 {
    max-width: 800px;
    width: 90%;
    margin: 70px auto;
    background-color: rgba(0, 0, 0, 0.8); 
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(255, 255, 255, 0.5); 
}

h1 {
    text-align: center;
    color: #03e9f4;
    margin-bottom: 20px;
}

.form-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.form-container form {
    width: 100%;
    max-width: 600px;
    padding: 20px;
    background-color: #333; 
    border: 1px solid #555; 
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
}

label {
    display: block;
    margin-bottom: 10px;
    font-weight: 600;
    color: #ddd; 
}

input[type="text"],
textarea,
select,
input[type="file"] {
    width: 100%;
    padding: 12px;
    border-radius: 5px;
    border: 1px solid #ccc; 
    background-color: #f2f2f2; 
    margin-bottom: 10px;
    font-size: 16px;
}

input[type="submit"] {
    background-color: #03e9f4;
    color: white;
    border: none;
    padding: 15px 20px;
    font-size: 18px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease;
    margin-top: 10px;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

select {
    background-color: #fff;
    color: #555;
    border: 1px solid #ddd; 
    border-radius: 5px;
    padding: 10px;
    font-size: 16px;
}

.preview-image {
    max-width: 100%;
    max-height: 200px;
    margin-top: 10px;
    border-radius: 5px;
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

    <div class="container2">
        <h1>Add New Venue</h1>

        <div class="form-container">
            <form id="edit-venue-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name">Venue Name</label>
                    <input id="name" name="name" type="text" required>
                </div>
                <div class="form-group">
                    <label for="venue_description">Venue Description</label>
                    <textarea id="venue_description" name="venue_description" rows="4" required></textarea>
                </div>
                <div class="form-group">
                    <label for="venue_image">Upload Image</label>
                    <input type="file" id="venue_image" name="venue_image" accept="image/*" required
                        onchange="previewImage(event)">
                    <img id="imagePreview" class="preview-image" src="#" alt="Preview Image" style="display: none;">
                </div>
                <div class="form-group">
                    <label for="type_id">Venue Type</label>
                    <select id="type_id" name="type_id" required>
                        <?php
                        while ($row_category = $result_categories->fetch_assoc()) {
                            echo '<option value="' . $row_category['id'] . '">' . $row_category['type'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" id="submit-edit" name="submit" value="Add Venue">
                </div>
            </form>
        </div>
        <button class="Back_Rmenu" style="padding-bottom:10px; display: block; margin: 0 auto; margin-top: 50px;" onclick="location.href='admin_display_venue.php'">Back to Venue Page</button>
    </div>

    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('imagePreview');
                output.style.display = 'block';
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
    <script src="navi_bar.js"></script>

</body>
</html>
<?php
$conn->close();
?>
