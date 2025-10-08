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

// Function to send approval email
function sendApprovalEmail($toEmail, $lastName, $userId, $venueName, $date, $timeSlot) {
  $subject = "Reservation Approved: " . $venueName;
  $message = "
  <html>
  <head>
  <title>Venue Reservation Approved</title>
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
      <div class='header'>Venue Reservation Approved</div>
      <div class='content'>
          <p>Dear $lastName (User ID: $userId),</p>
          <p>We are pleased to inform you that your reservation for the venue <b>$venueName</b> on <b>$date</b> during <b>$timeSlot</b> has been approved. Below are the details of your reservation:</p>
          <ul>
              <li><b>Venue Name:</b> $venueName</li>
              <li><b>Date:</b> $date</li>
              <li><b>Time Slot:</b> $timeSlot</li>
          </ul>
          <p>Please ensure that you arrive at the venue on time. If you need to make any changes to your reservation or if you have any questions, feel free to contact our support team.</p>
          <p>To manage your reservation or view other reservations, please log in to your account on our Venue Management System.</p>
          <p>Thank you for using our venue management system. We look forward to serving you and hope you have a great experience!</p>
      </div>
      <div class='footer'>
          <p>Best regards,</p>
          <p>Admin<br>University Venue Management System</p>
          <p>If you have any questions or need assistance, please contact our support team at <a href='gamer63450@gmail.com'>contact us</a>.</p>
      </div>
  </div>
  </body>
  </html>
  ";  
  
  // To send HTML mail, the Content-type header must be set
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  $headers .= "From: Admin of University Venue Management System" . "\r\n";

  if (mail($toEmail, $subject, $message, $headers)) {
      echo "<script>
          alert('Approval email sent successfully.');
          window.location.href = 'admin_application_review.php';
          </script>";
      exit;
  } else {
      echo "<script>alert('Failed to send approval email.');</script>";
  }
}

function sendRejectedEmail($toEmail, $lastName, $userId, $venueName, $date, $timeSlot) {
    $subject = "Reservation Rejected: " . $venueName;
    $message = "
    <html>
    <head>
    <title>Venue Reservation Rejected</title>
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
    <div class='header'>Venue Reservation Rejected</div>
    <div class='content'>
        <p>Dear $lastName (User ID: $userId),</p>
        <p>We regret to inform you that your reservation for the venue <b>$venueName</b> on <b>$date</b> during <b>$timeSlot</b> has been rejected. Below are the details of your reservation:</p>
        <ul>
            <li><b>Venue Name:</b> $venueName</li>
            <li><b>Date:</b> $date</li>
            <li><b>Time Slot:</b> $timeSlot</li>
        </ul>
        <p>Due to some reason, we are unable to accommodate your reservation request at this time. We apologize for any inconvenience this may cause.</p>
        <p>If you need to make any changes to your reservation or if you have any questions, feel free to contact our support team.</p>
        <p>To manage your reservation or view other reservations, please log in to your account on our Venue Management System.</p>
        <p>Thank you for using our venue management system. We look forward to serving you in the future.</p>
    </div>
    <div class='footer'>
        <p>Best regards,</p>
        <p>Admin<br>University Venue Management System</p>
        <p>If you have any questions or need assistance, please contact our support team at <a href='mailto:gamer63450@gmail.com'>contact us</a>.</p>
    </div>
    </div>
    </body>
    </html>
    ";  
    
    // To send HTML mail, the Content-type header must be set
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Admin of University Venue Management System" . "\r\n";
  
    if (mail($toEmail, $subject, $message, $headers)) {
        echo "<script>
            alert('Rejection email sent successfully.');
            window.location.href = 'admin_application_review.php';
            </script>";
        exit;
    } else {
        echo "<script>alert('Failed to send rejection email.');</script>";
    }
}

// Update reservation status
if (isset($_POST['update_status'])) {
    $reservation_id = $_POST['reservation_id'];
    $new_status = $_POST['status'];

    // Fetch user email and booking details
    $sql = "SELECT r.venue_name, r.date, t.time_slots, u.email, u.last_name, u.user_id 
            FROM reservations r 
            JOIN time_slots t ON r.slot_id = t.slot_id 
            JOIN users u ON r.user_id = u.user_id
            WHERE r.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $reservation_id);
    $stmt->execute();
    $stmt->bind_result($venueName, $date, $timeSlot, $userEmail, $lastName, $userId);
    $stmt->fetch();
    $stmt->close();

    $sql = "UPDATE reservations SET status_id = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $new_status, $reservation_id);

    if ($stmt->execute()) {
        echo "<script>alert('Status updated successfully.');</script>";

        // Send email if approved
        if ($new_status == 2) { // Assuming 2 is the approved status
            sendApprovalEmail($userEmail, $lastName, $userId, $venueName, $date, $timeSlot);
        } elseif ($new_status == 3) { // Assuming 3 is the rejected status
            sendRejectedEmail($userEmail, $lastName, $userId, $venueName, $date, $timeSlot);
        }
    } else {
        echo "<script>alert('Error updating status: " . $conn->error . "');</script>";
    }

    $stmt->close();
}

// Fetch pending reservations
$sql = "SELECT r.id, r.venue_name, r.date, t.time_slots, r.purpose 
        FROM reservations r 
        JOIN time_slots t ON r.slot_id = t.slot_id 
        WHERE r.status_id = 1"; // 1 is for pending status

$result = $conn->query($sql);
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
</head>
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

  <h1><b>PENDING RESERVATIONS</h1>
  <div class="container2">
    <table>
      <tr>
        <th>ID</th>
        <th>Venue Name</th>
        <th>Date</th>
        <th>Time Slot</th>
        <th>Purpose</th>
        <th>Action</th>
      </tr>
      <?php
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td>" . $row['id'] . "</td>";
              echo "<td>" . $row['venue_name'] . "</td>";
              echo "<td>" . $row['date'] . "</td>";
              echo "<td>" . $row['time_slots'] . "</td>";
              echo "<td>" . $row['purpose'] . "</td>";
              echo "<td>
                      <form method='POST' action=''>
                        <input type='hidden' name='reservation_id' value='" . $row['id'] . "'>
                               <select data-menu name='status' class='approval-select'>
                              <option value='2' selected>Approve</option>
                              <option value='3'>Reject</option>
                        </select>
                        <input type='submit' name='update_status' value='Update' class='update-button'>
                      </form>
                    </td>";
              echo "</tr>";
          }
      } else {
          echo "<tr><td colspan='6'>No pending reservations found.</td></tr>";
      }
      ?>
    </table>
  </div>
  <button class="Back_Rmenu" style="padding-bottom:10px; display: block; margin: 0 auto; margin-bottom: 20px;" onclick="location.href='admin_reservation_menu.php'">Back to Reservation Menu</button>
  <script src="navi_bar.js"></script>
</body>
</html>

<script>
$(document).ready(function() {
    $('select[data-menu]').each(function() {
        let select = $(this),
            options = select.find('option'),
            menu = $('<div />').addClass('select-menu'),
            button = $('<div />').addClass('button'),
            list = $('<ul />'),
            arrow = $('<em />').prependTo(button);

        options.each(function(i) {
            let option = $(this);
            list.append($('<li />').text(option.text()));
        });

        menu.css('--t', select.find(':selected').index() * -41 + 'px');

        select.wrap(menu);

        button.append(list).insertAfter(select);

        list.clone().insertAfter(button);
    });

    $(document).on('click', '.select-menu', function(e) {
        let menu = $(this);
        if (!menu.hasClass('open')) {
            menu.addClass('open');
        }
    });

    $(document).on('click', '.select-menu > ul > li', function(e) {
        let li = $(this),
            menu = li.parent().parent(),
            select = menu.children('select'),
            selected = select.find('option:selected'),
            index = li.index();

        menu.css('--t', index * -41 + 'px');
        selected.attr('selected', false);
        select.find('option').eq(index).attr('selected', true);

        menu.addClass(index > selected.index() ? 'tilt-down' : 'tilt-up');

        setTimeout(() => {
            menu.removeClass('open tilt-up tilt-down');
        }, 500);
    });

    $(document).click(function(e) {
        e.stopPropagation();
        if ($('.select-menu').has(e.target).length === 0) {
            $('.select-menu').removeClass('open');
        }
    });
});
</script>