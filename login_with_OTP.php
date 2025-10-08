<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Venue Management System</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <script>
        function requestOTP() {
            const email = document.getElementById('email').value;
            if (email) {
                fetch('request_otp.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `email=${email}`
                })
                .then(response => response.text())
                .then(data => {
                    alert(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            } else {
                alert('Please enter your email to request an OTP.');
            }
        }
    </script>
<style>
    body{
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-image: url('images/classroom.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;

    }

*,
*:before,
*:after{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}
body{
    background-color: #080710;
}

form{
    height: 520px;
    width: 400px;
    background-color: rgba(255,255,255,0.13);
    position: absolute;
    transform: translate(-50%,-50%);
    top: 50%;
    left: 50%;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 40px rgba(8,7,16,0.6);
    padding: 50px 35px;
}
form *{
    font-family: 'Poppins',sans-serif;
    color: #ffffff;
    letter-spacing: 0.5px;
    outline: none;
    border: none;
}
form h3{
    font-size: 32px;
    font-weight: 500;
    line-height: 42px;
    text-align: center;
}

label{
    display: block;
    margin-top: 10px;
    font-size: 16px;
    font-weight: 500;
}
input{
    display: block;
    height: 50px;
    width: 100%;
    background-color: rgba(255,255,255,0.07);
    border-radius: 3px;
    padding: 0 10px;
    margin-top: 8px;
    font-size: 14px;
    font-weight: 300;
}
::placeholder{
    color: #e5e5e5;
}
button{
    margin-top: 20px;
    width: 100%;
    background-color: #ffffff;
    color: #080710;
    padding: 15px 0;
    font-size: 18px;
    font-weight: 600;
    border-radius: 5px;
    cursor: pointer;
}
.Back_Rmenu{
    background-color: #1DA1F2;
    color: white;
    padding: 15px 0;
    border-radius: 4px;
    cursor: pointer;
    font-size: 20px;
    width: 100%;
    display: block;
    margin: 0 auto;
    text-align: center;
    margin-top: 15px;
   }

</style>
</head>
<body>
    <form method="POST" action="">
        <h3>Login with OTP</h3>

        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <button type="button" onclick="requestOTP()">Request OTP</button>
        </div>

        <div>
            <label for="otp">Enter OTP</label>
            <input type="text" id="otp" name="otp" required>
            <button type="submit">Login with OTP</button>  
        </div>
        <button class="Back_Rmenu" onclick="window.location.href='main.php'">Back</button>
    </form>
</body>
</html>

<?php
session_start();
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $entered_otp = $_POST['otp'];

    if (isset($_SESSION['otp']) && isset($_SESSION['otp_email']) && $entered_otp == $_SESSION['otp'] && $email == $_SESSION['otp_email']) {
        $_SESSION['user_id'] = $_SESSION['otp_user_id'];
        echo "<script>alert('Login Successful'); window.location.href='user_home.php';</script>";
    } else {
        echo "<script>alert('Invalid OTP or Email'); window.history.back();</script>";
    }
}
?>
