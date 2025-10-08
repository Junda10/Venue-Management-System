<?php
include 'db_connect.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $user_id = $_POST['user_id'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role_id = $_POST['role_id'];
    $phone_num = $_POST['phone_num'];
    $faculty_id = $_POST['faculty_id'];
    $term_id = $_POST['term_id'];

    // Check if user_id is empty
    if (empty($user_id)){
        echo "<script>alert('User ID cannot be empty.'); window.location='user_register.php';</script>";
        exit();
    }

    // Check if passwords match
    if ($password !== $confirm_password){
        echo "<script>alert('Passwords do not match.'); window.location='user_register.php';</script>";
        exit();
    }

    // Escape all input fields to prevent SQL injection
    $first_name = mysqli_real_escape_string($conn, $first_name);
    $last_name = mysqli_real_escape_string($conn, $last_name);
    $email = mysqli_real_escape_string($conn, $email);
    $password = mysqli_real_escape_string($conn, $password);
    $role_id = mysqli_real_escape_string($conn, $role_id);
    $phone_num = mysqli_real_escape_string($conn, $phone_num);
    $faculty_id = mysqli_real_escape_string($conn, $faculty_id);
    $term_id = mysqli_real_escape_string($conn, $term_id);

    // Check if email already exists
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0){
        echo "<script>alert('Email already exists.'); window.location='user_signin.php';</script>";
        exit();
    }

    // Check if user_id already exists
    $sql = "SELECT * FROM users WHERE user_id='$user_id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0){
        echo "<script>alert('User ID already exists.'); window.location='user_signin.php';</script>";
        exit();
    }

    // Insert new user into the database
    $insert_sql = "INSERT INTO users (first_name, last_name, user_id, email, password, role_id, phone_num, faculty_id, term_id)
                   VALUES ('$first_name', '$last_name', '$user_id', '$email', '$password', '$role_id', '$phone_num', '$faculty_id', '$term_id')";
    
    if (mysqli_query($conn, $insert_sql)) {
        // Send confirmation email
        $to = $email;
// Email subject
$subject = "Welcome to our university venue management system!";

// Email message
$message = "
<html>
<head>
    <title>Welcome to Our University Venue Management System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            font-size: 24px;
            color: #333333;
            margin-bottom: 20px;
        }
        p {
            margin-bottom: 10px;
            color: #666666;
        }
        ul {
            margin-bottom: 20px;
            padding-left: 20px;
        }
        li {
            margin-bottom: 8px;
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
        <h1>Welcome to Our University Venue Management System</h1>
        <div class='content'>
        <p>Dear $last_name (User ID: $user_id),</p>
        <p>Thank you for registering to use our university venue management system. We are delighted to have you on board! Our system is designed to provide you with a seamless experience in managing venue bookings and related activities.</p>
        <p><b>What to Expect:</b></p>
        <ul>
            <li><b>Ease of Use:</b> Our user-friendly interface ensures that booking your desired venues is just a few clicks away.</li>
            <li><b>Comprehensive Features:</b> Explore a range of features such as real-time availability, booking history, and more.</li>
            <li><b>Notifications:</b> Stay updated with instant notifications on booking confirmations and updates.</li>
        </ul>
        <p><b>Getting Started:</b></p>
        <p>To begin using our system, please proceed to the <a href='login_page_url'>login page</a> and log in with your registered credentials. Should you have any questions or require assistance, our support team is here to help.</p>
        <p>Once again, thank you for choosing our university venue management system. We look forward to serving you!</p>
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

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: University Venue Management System' . "\r\n";
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        
        if (mail($to, $subject, $message, $headers)) {
            echo "<script>alert('Registration successful. Please check your email.'); window.location='user_signin.php';</script>";
        } else {
            echo "<script>alert('Registration successful, but email could not be sent.'); window.location='user_signin.php';</script>";
            error_log('Failed to send email: ' . error_get_last()['message']);
        }
    } else {
        echo "Error: " . $insert_sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
