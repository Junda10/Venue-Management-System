<?php
include 'db_connect.php'; // Assuming this file contains your database connection

// Gather form data
$name = $_POST['name'];
$venue_type_id = $_POST['venue_type']; // Assuming this is the ID of the venue type selected
$venue_description = $_POST['venue_description'];
$comment = $_POST['comment'];

// File upload handling (if needed)
$target_dir = "uploads/"; // Adjust the path as per your setup
$target_file = $target_dir . basename($_FILES["images"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["images"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Check file size
if ($_FILES["images"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["images"]["tmp_name"], $target_file)) {
        echo "The file ". htmlspecialchars( basename( $_FILES["images"]["name"])). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

// Insert into venues table
$sql_insert_venues = "INSERT INTO venues (name, type_id, images, venue_description, comment)
                     VALUES ('$name', '$venue_type_id', '$images', '$venue_description', '$comment')";

if ($conn->query($sql_insert_venues) === TRUE) {
    $last_inserted_id = $conn->insert_id;

    // Insert into venue_remark table
    $sql_insert_remark = "INSERT INTO venue_remark (venue_id, venue_name, venue_description, comment)
                          VALUES ('$last_inserted_id', '$name', '$venue_description', '$comment')";

    if ($conn->query($sql_insert_remark) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql_insert_remark . "<br>" . $conn->error;
    }
} else {
    echo "Error: " . $sql_insert_venues . "<br>" . $conn->error;
}

$conn->close();
?>
