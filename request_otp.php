<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $email = mysqli_real_escape_string($conn, $email);

    // Fetch user's user_id from the database
    $sql = "SELECT user_id FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['user_id'];

        // Generate OTP
        $otp = rand(100000, 999999);

        // Store OTP in session variable
        $_SESSION['otp'] = $otp;
        $_SESSION['otp_email'] = $email;
        $_SESSION['otp_user_id'] = $user_id;

        // Send OTP to user's email
        $subject = "Your OTP for Login";
        $message = "Your OTP for login is $otp.";
        $headers = "From: Admin of University Venue Management System";

        if (mail($email, $subject, $message, $headers)) {
            echo "OTP has been sent to your email.";
        } else {
            echo "Failed to send OTP. Please try again.";
        }
    } else {
        echo "Email not found.";
    }
}
?>
