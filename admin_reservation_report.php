<?php
session_start();
include 'db_connect.php'; // Ensure this file connects to your MySQL database

$error_message = '';
$success_message = '';

$sql_profile = "SELECT a_image FROM admins WHERE admin_id = ?";
$stmt_profile = $conn->prepare($sql_profile);
$stmt_profile->bind_param("s", $_SESSION['admin_id']);
$stmt_profile->execute();
$stmt_profile->bind_result($a_image);
$stmt_profile->fetch();
$stmt_profile->close();

$default_image = 'images/profile.png';
$image_to_display = !empty($a_image) ? htmlspecialchars($a_image) : $default_image;


// Check if there is a success message to display
if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']); // Clear the message from the session
}

// Update reservation status
if (isset($_POST['update_status'])) {
    $reservation_id = $_POST['reservation_id'];
    $new_status = $_POST['status'];

    // Check if the status is 'Progress'
    $sql_check_status = "SELECT report_status FROM venue_remark WHERE id = ?";
    $stmt_check_status = $conn->prepare($sql_check_status);
    $stmt_check_status->bind_param("i", $reservation_id);
    $stmt_check_status->execute();
    $stmt_check_status->bind_result($current_status);
    $stmt_check_status->fetch();
    $stmt_check_status->close();

    if ($current_status == 'Progress') {
        // Prepare SQL statement
        $sql_update = "UPDATE venue_remark SET report_status = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);

        if (!$stmt_update) {
            $error_message = "Prepare failed: " . $conn->error;
        } else {
            // Bind parameters and execute statement
            $stmt_update->bind_param("si", $new_status, $reservation_id);

            if ($stmt_update->execute()) {
                $_SESSION['success_message'] = "Status updated successfully.";
                header('Location: admin_reservation_report.php'); // Redirect to avoid resubmission
                exit;
            } else {
                $error_message = "Error updating status: " . $stmt_update->error;
            }

            $stmt_update->close();
        }
    } else {
        $error_message = "Status cannot be changed from 'Solved'.";
    }
}

// Handle form submission for adding reservation remark
if (isset($_POST['submit_reservation'])) {
    // Validate and sanitize inputs
    $venue_id = isset($_POST['venue_name']) ? $_POST['venue_name'] : '';
    $comment = isset($_POST['comment']) ? $_POST['comment'] : '';
    $report_status = isset($_POST['report_status']) ? $_POST['report_status'] : '';
    $report_dates = isset($_POST['report_dates']) ? $_POST['report_dates'] : '';

    // Check if required fields are empty
    if (empty($venue_id) || empty($comment) || empty($report_status) || empty($report_dates)) {
        $error_message = "All fields are required.";
    } else {
        // Fetch the venue type based on the selected venue_id
        $sql_venue_type = "SELECT vt.type 
                           FROM venues v 
                           JOIN venue_types vt ON v.type_id = vt.id 
                           WHERE v.id = ?";
        $stmt_venue_type = $conn->prepare($sql_venue_type);
        $stmt_venue_type->bind_param("i", $venue_id);
        $stmt_venue_type->execute();
        $stmt_venue_type->bind_result($venue_type);
        $stmt_venue_type->fetch();
        $stmt_venue_type->close();

        // Prepare SQL statement
        $sql_insert = "INSERT INTO venue_remark (venue_name, report_status, venue_type, comment, report_dates) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);

        if (!$stmt_insert) {
            $error_message = "Prepare failed: " . $conn->error;
        } else {
            // Bind parameters and execute statement
            $stmt_insert->bind_param("sssss", $venue_id, $report_status, $venue_type, $comment, $report_dates);

            if ($stmt_insert->execute()) {
                $_SESSION['success_message'] = "Reservation remark added successfully.";
                header('Location: admin_reservation_report.php'); // Redirect to avoid resubmission
                exit;
            } else {
                $error_message = "Error adding reservation remark: " . $stmt_insert->error;
            }

            $stmt_insert->close();
        }
    }
}

// Fetch venue types for selection
$sql_types = "SELECT id, type FROM venue_types ORDER BY type";
$result_types = $conn->query($sql_types);

// Fetch venues based on selected venue type
$venue_type_id = isset($_POST['venue_type']) ? $_POST['venue_type'] : null;
$sql_venues = "SELECT id, name FROM venues WHERE type_id = ? ORDER BY name";
$stmt_venues = $conn->prepare($sql_venues);
$stmt_venues->bind_param("i", $venue_type_id);
$stmt_venues->execute();
$result_venues = $stmt_venues->get_result();

// Fetch all data from venue_remark table
$sql_remarks = "SELECT vr.id, v.name AS venue_name, vr.comment, vr.report_status, vr.report_dates, vr.venue_type 
                FROM venue_remark vr 
                JOIN venues v ON vr.venue_name = v.id 
                ORDER BY vr.id DESC"; // Newest entries first
$result_remarks = $conn->query($sql_remarks);

$conn->close(); // Close database connection
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
    <style>
* {
    box-sizing: border-box;
}

select, input[type="date"] {
    padding: 10px;
    margin-top: 10px;
    border-radius: 5px;
    border: none;
    cursor: pointer;
    transition: background-color 0.3s ease, color 0.3s ease;
}

select {
    background-color: #333;
    color: #fff;
}

input[type="date"] {
    background-color: #333;
    color: #fff;
}
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

<h1><b>VENUE REPORTS</b></h1>

<div class="container2">
    <form method="POST" action="admin_reservation_report.php">
        <input type="hidden" name="form_submitted" value="1"> <!-- Add this hidden input -->
        <table>
            <tr>
                <th>Venue Type</th>
                <th>Venue Name</th>
                <th>Comment</th>
                <th>Report Status</th>
                <th>Report Date</th>
                <th>Action</th>
            </tr>
            <tr>
                <td>
                    <select name="venue_type" onchange="this.form.submit()">
                        <option value="">Select Venue Type</option>
                        <?php while ($row_type = $result_types->fetch_assoc()) : ?>
                            <option value="<?php echo $row_type['id']; ?>" <?php if ($venue_type_id == $row_type['id']) echo 'selected'; ?>>
                                <?php echo $row_type['type']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </td>
                <td>
                    <select name="venue_name">
                        <option value="">Select Venue</option>
                        <?php while ($row_venue = $result_venues->fetch_assoc()) : ?>
                            <option value="<?php echo $row_venue['id']; ?>"><?php echo $row_venue['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </td>
                <td><input type="text" name="comment"></td>
                <td>
                    <select name="report_status">
                        <option value="Progress">Progress</option>
                        <option value="Solved">Solved</option>
                    </select>
                </td>
                <td><input type="date" name="report_dates"></td> <!-- Added report_dates input -->
                <td><input type="submit" name="submit_reservation" value="Add Remark"></td>
            </tr>
        </table>
    </form>

</div>
<h1><b>RESERVATION REPORTS</b></h1>

<div class="container2">

    <table>
        <tr>
            <th>ID</th>
            <th>Venue Name</th>
            <th>Comment</th>
            <th>Report Status</th>
            <th>Report Date</th>
            <th>Venue Type</th>
            <th>Action</th>
        </tr>
        <?php while ($row_remark = $result_remarks->fetch_assoc()) : ?>
            <tr>
                <td><?php echo $row_remark['id']; ?></td>
                <td><?php echo $row_remark['venue_name']; ?></td>
                <td><?php echo $row_remark['comment']; ?></td>
                <td><?php echo $row_remark['report_status']; ?></td>
                <td><?php echo $row_remark['report_dates']; ?></td>
                <td><?php echo $row_remark['venue_type']; ?></td>
                <td>
                    <?php if ($row_remark['report_status'] == 'Progress') : ?>
                        <form method="POST" action="admin_reservation_report.php">
                            <input type="hidden" name="reservation_id" value="<?php echo $row_remark['id']; ?>">
                            <select name="status">
                                <option value="Progress">Progress</option>
                                <option value="Solved">Solved</option>
                            </select>
                            <input type="submit" name="update_status" value="Change Status">
                        </form>
                    <?php else : ?>
                        Solved 
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>
<button class="Back_Rmenu" style="padding-bottom:10px;" onclick="location.href='admin_reservation_menu.php'">Back to Reservation Menu</button>

<script src="navi_bar.js"></script>

</body>
</html>
