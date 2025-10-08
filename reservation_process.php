<?php
// Include database connection file
require_once 'db_connect.php';

// Start session to access user ID
session_start();

// Function to send booking email to admins
function sendAdminEmail($adminEmails, $firstName, $lastName, $venueName, $date, $timeSlot, $purpose, $userId) {
    $subject = "New Pending Booking Request";
    $message = "
    <html>
    <head>
        <title>New Pending Booking Request</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                color: #333;
            }
            .container {
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 5px;
                background-color: #f9f9f9;
                width: 80%;
                margin: auto;
            }
            .header {
                font-size: 24px;
                margin-bottom: 20px;
            }
            .content {
                font-size: 16px;
                line-height: 1.6;
            }
            .footer {
                margin-top: 20px;
                font-size: 14px;
                color: #555;
            }
        </style>
    </head>
    <body>
    <div class='container'>
        <div class='header'>A new booking request is pending your approval.</div>
        <div class='content'>
            <h2>Dear Admin,</h2>
            <p>There is a new pending booking request. Here are the details:</p>
            <ul>
                <li><b>User ID:</b> $userId</li>
                <li><b>User Name:</b> $firstName $lastName</li>
                <li><b>Venue Name:</b> $venueName</li>
                <li><b>Date:</b> $date</li>
                <li><b>Time Slot:</b> $timeSlot</li>
                <li><b>Purpose:</b> $purpose</li> 
            </ul>
            <p>Please log in to the system to approve or reject this booking request.</p>
        </div>
        <div class='footer'>
            <p>Best regards,</p>
            <p>University Venue Management System</p>
        </div>
    </div>
    </body>
    </html>
    ";

    // To send HTML mail, the Content-type header must be set
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: University Venue Management System' . "\r\n";

    // Send email to each admin
    foreach ($adminEmails as $adminEmail) {
        mail($adminEmail, $subject, $message, $headers);
    }
}

// Function to send booking confirmation email to user
function sendUserEmail($userEmail, $firstName, $lastName, $venueName, $date, $timeSlot, $purpose, $reservationId) {
    $subject = "Booking Request Confirmation";
    $message = "
    <html>
    <head>
        <title>Booking Request Confirmation</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                color: #333;
            }
            .container {
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 5px;
                background-color: #f9f9f9;
                width: 80%;
                margin: auto;
            }
            .header {
                font-size: 24px;
                margin-bottom: 20px;
            }
            .content {
                font-size: 16px;
                line-height: 1.6;
            }
            .footer {
                margin-top: 20px;
                font-size: 14px;
                color: #555;
            }
        </style>
    </head>
    <body>
    <div class='container'>
        <div class='header'>Your booking request has been received.</div>
        <div class='content'>
            <h2>Dear $firstName $lastName,</h2>
            <p>Thank you for your booking request. Here are the details:</p>
            <ul>
                <li><b>Reservation ID:</b> $reservationId</li>
                <li><b>Venue Name:</b> $venueName</li>
                <li><b>Date:</b> $date</li>
                <li><b>Time Slot:</b> $timeSlot</li>
                <li><b>Purpose:</b> $purpose</li> 
            </ul>
            <p>Your request is currently pending approval. We will notify you once it has been reviewed.</p>
        </div>
        <div class='footer'>
            <p>Best regards,</p>
            <p>University Venue Management System</p>
        </div>
    </div>
    </body>
    </html>
    ";

    // To send HTML mail, the Content-type header must be set
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: University Venue Management System' . "\r\n";

    // Send email to the user
    mail($userEmail, $subject, $message, $headers);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $venue_id = $_POST['venue_id'];
    $date = $_POST['date'];
    $time_slot_id = $_POST['time_slot']; // Single selected time slot ID
    $purpose = $_POST['purpose'];
    $user_id = $_SESSION['user_id']; // Assuming user_id is stored in session after login

    // Check if user_id is set in the session
    if (!isset($user_id)) {
        echo "Error: User is not logged in.";
        exit();
    }

    // Retrieve user email, first name, and last name from users table based on user_id
    $sql_user = "SELECT email, first_name, last_name FROM users WHERE user_id = ?";
    $stmt_user = $conn->prepare($sql_user);
    if ($stmt_user === false) {
        echo "Error preparing statement: " . $conn->error;
        exit();
    }
    $stmt_user->bind_param("s", $user_id);
    $stmt_user->execute();
    $stmt_user->bind_result($userEmail, $firstName, $lastName);
    $stmt_user->fetch();
    $stmt_user->close();

    if (!$userEmail || !$firstName || !$lastName) {
        echo "Error: User details not found for user ID $user_id.";
        exit();
    }

    // Retrieve venue_name from venues table based on venue_id
    $sql_venue = "SELECT name FROM venues WHERE id = ?";
    $stmt_venue = $conn->prepare($sql_venue);
    $stmt_venue->bind_param("i", $venue_id);
    $stmt_venue->execute();
    $stmt_venue->bind_result($venue_name);
    $stmt_venue->fetch();
    $stmt_venue->close();

    if (!$venue_name) {
        echo "Error: Venue name not found for venue ID $venue_id.";
        exit();
    }

    // Retrieve the actual time slot value from time_slots table based on time_slot_id
    $sql_slot = "SELECT time_slots FROM time_slots WHERE slot_id = ?";
    $stmt_slot = $conn->prepare($sql_slot);
    $stmt_slot->bind_param("s", $time_slot_id);
    $stmt_slot->execute();
    $stmt_slot->bind_result($time_slot_value);
    $stmt_slot->fetch();
    $stmt_slot->close();

    if (!$time_slot_value) {
        echo "Error: Time slot not found for slot ID $time_slot_id.";
        exit();
    }

    // Check for overlapping reservations
    $sql_overlap = "SELECT COUNT(*) FROM reservations WHERE venue_id = ? AND date = ? AND slot_id = ?";
    $stmt_overlap = $conn->prepare($sql_overlap);
    $stmt_overlap->bind_param("iss", $venue_id, $date, $time_slot_id);
    $stmt_overlap->execute();
    $stmt_overlap->bind_result($count);
    $stmt_overlap->fetch();
    $stmt_overlap->close();

    if ($count > 0) {
        echo "The selected time slot $time_slot_value is already booked. Please choose another slot.";
        exit();
    }

    // Insert the reservation into the database
    $sql_insert = "INSERT INTO reservations (venue_id, venue_name, user_id, date, slot_id, purpose, status_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $status_id = 1; // Assuming status_id 1 is for pending reservations
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("isssssi", $venue_id, $venue_name, $user_id, $date, $time_slot_id, $purpose, $status_id);

    if ($stmt_insert->execute()) {
        $reservation_id = $stmt_insert->insert_id;
        $_SESSION['reservation_success'] = true;
        $_SESSION['reservation_id'] = $reservation_id; // Store the reservation ID in session
        
        // Retrieve all admin emails from the admins table
        $sql_admin = "SELECT email FROM admins";
        $result_admin = $conn->query($sql_admin);
        $adminEmails = [];
        while ($row = $result_admin->fetch_assoc()) {
            $adminEmails[] = $row['email'];
        }
        
        // Send email notification to all admins
        sendAdminEmail($adminEmails, $firstName, $lastName, $venue_name, $date, $time_slot_value, $purpose, $user_id);
        
        // Send confirmation email to the user
        sendUserEmail($userEmail, $firstName, $lastName, $venue_name, $date, $time_slot_value, $purpose, $reservation_id);
        
        header("Location: reservation_success.php");
        exit();
    } else {
        echo "Error: " . $sql_insert . "<br>" . $stmt_insert->error;
    }

    $stmt_insert->close();

} else {
    header("Location: reservation.php");
    exit();
}

$conn->close();
?>
