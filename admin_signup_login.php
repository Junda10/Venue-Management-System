<!DOCTYPE html>
<html>
<head>
	<title>University Venue Management System</title>
	<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="back.css">
</head>

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
    margin-top: 30px;
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
    margin-top: 50px;
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
<body>
<form method="POST" action="">
    <h3><b>ADMIN LOGIN</b></h3>

    <div class="input-group">
        <label for="chk" aria-hidden="true">Admin ID</label>
        <input type="text"  name="admin_id" required>
        <label for="password">Password</label>
        <input type="password" name="password" required>
        <button type="submit" name="login">Login</button>
        <p class="Back_Rmenu" onclick="window.location.href='main.php'">Back</p>
        
        <!--forget password-->
    </form>     
    </div>    
        </div>    
    </div>
</body>
</html>
</body>
</html>

<?php
session_start();
include 'db_connect.php'; // Assuming this file contains your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login'])) {
        // Login logic
        $admin_id = mysqli_real_escape_string($conn, $_POST['admin_id']);
        $password = mysqli_real_escape_string($conn, $_POST['password']); // Changed to match your HTML input name

        $sql = "SELECT * FROM admins WHERE admin_id='$admin_id' AND password='$password'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['admin_id'] = $row['admin_id']; // Assuming 'admin_id' is the column name in your table
            echo "<script>alert('Login Successful'); window.location.href='admin_mainmenu.php';</script>";
        } else {
            echo "<script>alert('Login Failed'); window.history.back();</script>";
        }
    }
    mysqli_close($conn);
}
?>
