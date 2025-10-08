<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Venue Management System</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <style>
body{
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    align-items: center;
    height: 190vh;
    background-image: url('images/classroom.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    background-attachment: fixed;
}
@media (max-width: 600px){
    .border-container{
        width: 95%;
    }   
}

    *,
*:before,
*:after{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}

h1{
    font-size:60px;
}

form{
    margin-top:400px;
    height: 1300px;
    width: 800px;
    background-color: rgba(255,255,255,0.13);
    position: absolute;
    transform: translate(-50%,-50%);
    top: 50%;
    left: 50%;
    border-radius: 10px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255,255,255,0.1);
    box-shadow: 0 0 40px rgba(8,7,16,0.6);
    padding: 40px 35px;
}
form *{
    font-family: 'Poppins',sans-serif;
    color: black;
    letter-spacing: 0.25px;
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
    margin-top: 20px;
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
.input-group {
    margin-bottom: 20px;
}

.input-group label {
    display: block;
    font-size: 16px;
    font-weight: 500;
    margin-bottom: 8px;
    color: #ffffff; 
}

.input-group input,
.input-group select {
    width: 100%;
    height: 40px;
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: rgba(255, 255, 255, 0.1); 
    color: #ffffff; 
    box-sizing: border-box;
    transition: border-color 0.3s ease;
}

.input-group input:focus,
.input-group select:focus {
    outline: none;
    border-color: #66afe9; 
}

.input-group.flex {
    display: flex;
}

.input-half {
    width: 50%;
    padding-right: 10px;
}

.input-group .custom-select {
    position: relative;
    width: 100%;
    margin-top: 8px;
}

.input-group .custom-select select {
    width: 100%;
    height: 40px;
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    background-color: rgba(255, 255, 255, 0.1);
    color: #ffffff;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    background-image: url('data:image/svg+xml;utf8,<svg fill="#ffffff" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/><path d="M0 0h24v24H0z" fill="none"/></svg>');
    background-repeat: no-repeat;
    background-position-x: calc(100% - 10px);
    background-position-y: center;
    padding-right: 30px; 
}

.input-group .custom-select select:focus {
    outline: none;
    border-color: #66afe9;
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
    <div class="nav">
        <h1`>Venue Management System</h1>
    </div>

    <form id="registerForm" action="user_registerprocess.php" method="post">
            <h1 style="text-align:center; padding-top: 20px;">REGISTER FORM</h1>                    
                    <div class="input-group">
                    <label for="user_id">User ID</label>
                    <input type="text" id="user_id" name="user_id" required>
                </>
                <div class="input-group">
                    <label for="first-name">First Name</label>
                    <input type="text" id="first_name" name="first_name" required>
                </div>
                <div class="input-group">
                    <label for="last-name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" required>
                </div>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="role_id">Role</label>
                    <select id="role_id" name="role_id" required>
                        <option value="1">Student</option>
                        <option value="2">Lecturer</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="phone_num">Phone Number(+60)</label>
                    <input type="text" id="phone_num" name="phone_num">
                </div>
                <div class="input-group">
                    <label for="faculty_id">Faculty</label>
                    <select id="faculty_id" name="faculty_id" required>
                        <option value="1">FIST - Faculty of Science and Technology</option>
                        <option value="2">FOL - Faculty of Law</option>
                        <option value="3">FET - Faculty of Engineering and Technology</option>
                        <option value="4">FOB - Faculty of Business</option>
                    </select>
                </div>
                <div class="input-group">
                    <label for="term_id">Term</label>
                    <select id="term_id" name="term_id" required>
                        <option value="1">17/18</option>
                        <option value="2">18/19</option>
                        <option value="3">19/20</option>
                        <option value="4">20/21</option>
                        <option value="5">21/22</option>
                        <option value="6">22/23</option>
                        <option value="7">23/24</option>
                    </select>
                </div>
                    <div class="input-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required minlength="8">
                    </div>
                    <div class="input-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" required minlength="8">
                    </div>
                </div>
                <button type="submit">Register</button>
                <button class="Back_Rmenu" onclick="window.location.href='main.php'">Back</button>
            </form>
        </div>
        </div>
    </div>
</div>
</body>
</html>


<script>
document.addEventListener('DOMContentLoaded', () => {
    const dropdownContents = document.querySelectorAll('.dropdown-content');
    const dropbtns = document.querySelectorAll('.dropbtn');
    const hiddenInputs = document.querySelectorAll('[id$=_id]');

    dropbtns.forEach((dropbtn, index) => {
        dropbtn.addEventListener('click', () => {
            dropdownContents[index].classList.toggle('open');
        });
    });

    dropdownContents.forEach((dropdownContent, index) => {
        dropdownContent.addEventListener('click', (e) => {
            if (e.target.matches('div')) {
                dropbtns[index].textContent = e.target.textContent;
                hiddenInputs[index].value = e.target.getAttribute('data-value');
                dropdownContent.classList.remove('open');
            }
        });
    });

    // Close dropdowns if clicked outside
    document.addEventListener('click', (e) => {
        dropbtns.forEach((dropbtn, index) => {
            if (!dropbtn.contains(e.target)) {
                dropdownContents[index].classList.remove('open');
            }
        });
    });
});


    </script>