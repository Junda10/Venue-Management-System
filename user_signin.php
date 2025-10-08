<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Venue Management System</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="back.css">
    <script>
        function showAlertAndRedirect(message, url){
            alert(message);
            window.location.href = url;
        }
    </script>
<style>
body{
    font-family: 'Montserrat', Arial, sans-serif;
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
    margin-top: 30px;
    width: 100%;
    background-color: #ffffff;
    color: #080710;
    padding: 15px 0;
    font-size: 18px;
    font-weight: 600;
    border-radius: 5px;
    cursor: pointer;
}

</style>
</head>
<body>
    <form method="POST" action="">
    <h3><b>USER LOGIN</b></h3>

    <div>
    <label for="chk" aria-hidden="true">User ID</label>
    <input type="text" id="user_id" name="user_id" required>
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>
        <button type="submit">Login</button>
    </form>    
    </br></br><p style="font-weight:100">Don't Have An Account? <a href="user_register.php">Register Now</a></p>
    <p style="font-weight:100">Forgot password?<a href="login_with_OTP.php">Request OTP</a></p>
    <p class="Back_Rmenu" onclick="window.location.href='main.php'">Back</p>
    </div>    
</body>
</html>

<?php
session_start();
include 'db_connect.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];

    $user_id = mysqli_real_escape_string($conn, $user_id);
    $password = mysqli_real_escape_string($conn, $password);

    $sql = "SELECT * FROM users WHERE user_id='$user_id' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['user_id'];
        echo "<script>alert('Login Successful'); window.location.href='user_home.php';</script>";
    } else {
        echo "<script>alert('Login Failed'); window.history.back();</script>";
    }
}
?>

