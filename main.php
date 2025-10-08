<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Venue Management System</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
</head>
<body>

<style>
body {
    font-family: 'Montserrat', Arial, sans-serif;
    margin: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center; 
    min-height: 100vh; 
    background-image: url('images/classroom.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
}

.container {
    text-align: center;
    background-image: url('images/dark.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    padding: 30px;
    padding-top: 40px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-top: 20px;
    margin-bottom:20px;
    width: 80%;
    max-width: 600px;
    border: 4px solid #5C4033;
}

h1 {
    font-size: 2em;
    margin: 10px 0;
}

h2 {
    font-size: 1.5em;
    margin: 20px 0;
}

.account-type {
    display: flex;
    justify-content: space-around;
    margin: 20px 0;
}

.account {
    border: 2px solid #000;
    padding: 20px;
    border-radius: 10px;
    cursor: pointer;
    transition: background-color 0.4s, transform 0.3s;
}

.account:hover {
    background-color: #f0f0f0;
    transform: scale(1.05);
}

.account img {
    max-width: 80px;
}

.register {
    margin-top: 20px;
}
.render {
  padding-top:50px;
  font-weight: 700;
  font-size: 50px; 
  color: #f5f5f5;
  text-align: center;
  text-shadow:
    gray 0.05em 0.05em 0.1em,
    #9c9c9c 1px 1px 1px,
    rgba(16, 16, 16, 0.4) 1px 8px 8px,
    gray -0.15em -0.1em 0.2em;
  transition: all 0.3s ease;
}

.render:hover {
  margin-top: -20px; 
  text-shadow:
    white 0.05em 0.05em 0.1em,
    #9c9c9c 1px 1px 1px,
    rgba(16, 16, 16, 0.4) 1px 16px 12px,
    white -0.15em -0.1em 0.2em;
}


</style>
    <span class="render">UNIVERSITY VENUE <br> MANAGEMENT SYSTEM</span>
    <div class="container">
        <main>
            <h1 style="color:#00c04b">LOGIN</h1>
            <h2 style="color:#00c04b">Choose Your Account Type</h2>
            <div class="account-type">
                <div class="account user" onclick="window.location.href='user_signin.php'">
                    <img src="images/user.png" alt="User Icon">
                    <p style="font-weight:bold; color:black;">USER</p>
                </div>
                <div class="account admin" onclick="window.location.href='admin_signup_login.php'">
                    <img src="images/admin.jpg" alt="Admin Icon">
                    <p style="font-weight:bold; color:black;">ADMIN</p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
