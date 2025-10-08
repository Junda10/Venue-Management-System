<?php
include 'db_connect.php'; // Include database connection script

session_start(); // Start session

if (!isset($_SESSION['user_id'])) {
    header('Location: main.php'); // Redirect to main.php if user is not logged in
    exit();
}

// Fetch user's profile image
$sql_profile = "SELECT u_image FROM users WHERE user_id = ?";
$stmt_profile = $conn->prepare($sql_profile);
$stmt_profile->bind_param("s", $_SESSION['user_id']);
$stmt_profile->execute();
$stmt_profile->bind_result($u_image);
$stmt_profile->fetch();
$stmt_profile->close();

// Set default image if u_image is empty
$default_image = 'images/profile.png';
$image_to_display = !empty($u_image) ? htmlspecialchars($u_image) : $default_image;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>University Venue Management System</title>
  <link rel="stylesheet" href="navi_bar_white.css">
  <style>
.time-slot {
  display: block;
  margin-bottom: 10px;
}
<style>
*{
  box-sizing: border-box;
}

body{

  background-color:#1A1A1A;
  background-attachment: fixed;
  color: black;
  background-size: cover; 
  font-family: 'Montserrat', Arial, sans-serif;
  margin-bottom: 60px;
  padding: 0;
  font-size: 20px;
  text-align: justify;
}

.time-slot {
  display: block;
  margin-bottom: 10px;
}

.reservation-container {
  margin-top: 30px;
  background: #EFFDFF;
  border-radius: 20px;
  padding: 20px;
  box-shadow: 6px 6px 10px blue, -6px -6px 10px #3765f3;
  width: 1000px;
  max-width: 100%; 
}

  .reservation-container h1 {
  font-size: 1.5rem;
  color: #333;
  text-align: center;
  margin-bottom: 20px;
}

  .reservation-container img{
      width: 30%;
      height: auto;
      border-radius: 8px;
      margin-bottom: 10px;
  }

  .reservation-container form{
      background-color: #f9f9f9;
      padding: 10px;
      border-radius: 8px;
      box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
      display: inline-block;
      text-align: left;
      width: 100%;
      max-width: 900px;
  }

  .reservation-container label{
      display: block;
      margin-bottom: 8px;
      font-weight: bold;
  }

  .reservation-container input[type="date"],
  .reservation-container textarea{
      width: 100%;
      padding: 10px;
      margin: 5px 0 15px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 16px;
  }

  .reservation-container .time-slots{
      display: grid;
      grid-template-columns: repeat(4, 1fr);
      gap: 10px;
      margin-bottom: 10px;
  }

.content {
  display: flex;
  justify-content: space-between;
  background: #EFFDFF;
}

  .time-slot{
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #f0f8ff;
      border-radius: 20px;
      padding: 10px 20px;
      cursor: pointer;
      transition: background-color 0.3s;
  }

  .time-slot input{
      display: none;
  }

  .time-slot span{
      font-size: 16px;
      color: #1e90ff;
  }

  .time-slot:hover{
      background-color: #e0f7fa;
  }

  .time-slot input:checked + span{
      background-color: #20c997;
      color: white;
      padding: 5px 10px;
      border-radius: 20px;
  }

  select {
      width: 100%;
      padding: 10px;
      margin: 5px 0 15px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 16px;
  }

  input[type="date"],
  textarea {
      width: 100%;
      padding: 10px;
      margin: 5px 0 15px 0;
      border: 1px solid #ccc;
      border-radius: 4px;
      font-size: 16px;
  }

  .button-container{
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      margin-top: 20px;
  }

  button[type="submit"],
  button[type="button"]{
      background-color: #3498db;
      color: #fff;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      border-radius: 4px;
      font-size: 16px;
      transition: background-color 0.3s ease;
  }

  button[type="submit"]:hover,
  button[type="button"]:hover{
      background-color: #2980b9;
  }

  button[type="button"]{
      background-color: #6c757d;
  }

  button[type="button"]:hover{
      background-color: #5a6268;
  }

  button[type="submit"]{
      background-color: #007bff;
  }

  button[type="submit"]:hover{
      background-color: #0056b3;
  }

  .alert{
  color: #f44336;
  padding: 10px;
  margin-bottom: 10px;
  border-radius: 5px;
  font-size: 14px;
  font-weight: bold;
}
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;900&display=swap');

.container2 {
  position: relative;
  margin:auto;
  width: 1000px;
  height: auto;
  border-radius: 20px;
  padding: 40px;
  background: #1A1A1A;
  border:2px solid white;
  box-shadow: 14px 14px 20px #3765f3, -14px -14px 20px blue;
  display: flex;
  align-items: center;
  justify-content: center;
  font-family: 'Poppins', Arial, sans-serif;
  flex-direction: column; 
  align-items: center; 
  justify-content: center; 
}


.brand-logo img {
  position: relative;
  width: 50%;
  border-radius: 20%;
  box-sizing: border-box;
  box-shadow: 7px 7px 10px #cbced1, -7px -7px 10px white;
  display: block; 
  margin: auto; 
}

.brand-title {
  margin-top: 10px;
  font-weight: 900;
  font-size: 1.8rem;
  color: #1DA1F2;
  letter-spacing: 1px;
  text-align: center;
}

form {
  display: flex;
  flex-direction: column;
  background: #EFFDFF;
}

label {
  margin-top: 10px;
  font-weight: 900;
  color: #1DA1F2;
}

input[type="date"],
textarea {
  width: 100%;
  padding: 10px;
  margin-top: 5px;
  border: 2px solid #cbced1;
  border-radius: 10px;
  background: #ecf0f3;
  box-shadow: inset 4px 4px 4px #cbced1, inset -4px -4px 4px white;
  resize: vertical;
}

.time-slots {
  margin-top: 5px;
  padding: 10px;
  border: 2px solid #cbced1;
  border-radius: 10px;
  background: #ecf0f3;
  box-shadow: inset 4px 4px 4px #cbced1, inset -4px -4px 4px white;
}

.button-container {
  margin-top: 20px;
  display: flex;
  justify-content: space-between;
}

button {
  flex: 1;
  padding: 10px;
  color: white;
  background: #1DA1F2;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  font-weight: 900;
  box-shadow: 4px 4px 4px #cbced1, -4px -4px 4px white;
  transition: 0.3s;
}

button:hover {
  box-shadow: none;
  transform: translateY(2px);
}

#reservationForm{
  background: #EFFDFF;
}
.profile-icon {
  position: absolute;
  left: 70px;
  top: 30px;
  width: 50px;
  height: 50px;
  background-image: url('images/profile2.png');
  background-size: cover;
  cursor: pointer;
}
</style>
</head>
<body>
    <div class="container">
    <div class="profile-icon" onclick="window.location.href='profile.php'">
        <img src="<?php echo htmlspecialchars($image_to_display); ?>" alt="Profile Image">
    </div>
    <nav class="mynav">
      <ul>
        <li><a href="user_home.php">Home</a></li>
        <li class="dropdown">
          <a href="#">Reservation</a>
          <ul class="dropdown-content">
            <li><a href="reservation.php">Book Venue</a></li>
            <li><a href="past_reservation.php">Past Reservations</a></li>
            <li><a href="upcoming_reservation.php">Upcoming Reservations</a></li>
          </ul>
        </li>
        <li><a href="logout.php">Log Out</a></li>
      </ul>
    </nav>
    <span class="target"></span>
  </div>

  <?php
  $venue_id = $venue_name = $venue_images = $venue_type = '';
  if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id']) && isset($_GET['name']) && isset($_GET['images']) && isset($_GET['type'])) {
      $venue_id = $_GET['id'];
      $venue_name = $_GET['name'];
      $venue_images = $_GET['images'];
      $venue_type = $_GET['type'];
  } else {
      header("Location: reservation.php");
      exit();
  }
  ?>

  <div class="container2">
    <div class="brand-logo">
      <img src="images/<?php echo htmlspecialchars($venue_images); ?>" alt="<?php echo htmlspecialchars($venue_name); ?>">
    </div>
    <div class="brand-title">
      <h1><?php echo htmlspecialchars($venue_name); ?></h1>
    </div>

    <div class="reservation-container">
      <div class="form-container">
        <form id="reservationForm" action="reservation_process.php" method="post">
          <input type="hidden" name="venue_id" value="<?php echo htmlspecialchars($venue_id); ?>">
          <input type="hidden" name="venue_name" value="<?php echo htmlspecialchars($venue_name); ?>">
          
          <label for="date">Select Date:</label>
          <input type="date" id="date" name="date" required onchange="updateTimeSlots()">
          <br>

          <label for="available_time_slots">Available Time Slots:</label>
          <div id="available_time_slots" class="time-slots"></div>
          <br>

          <label for="purpose">Purpose of Reservations:</label>
          <textarea id="purpose" name="purpose" rows="4" cols="50" required></textarea>
          <br>

          <div class="button-container">
            <a href="reservation.php"><button type="button">Back</button></a>
            <button type="submit" id="submitBtn">Next</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const dateInput = document.getElementById('date');
      const availableTimeSlotsContainer = document.getElementById('available_time_slots');
      const form = document.getElementById('reservationForm');
      const venueInput = document.querySelector('input[name="venue_id"]');

      function updateTimeSlots() {
        const selectedDate = dateInput.value;
        const selectedVenueId = venueInput.value;
        const currentDate = new Date().toISOString().split('T')[0];

        clearAlerts();

        if (selectedDate === '') {
          return; 
        }

        if (selectedDate < currentDate) {
          showAlert('The selected date has already passed. Kindly choose a future date.');
          availableTimeSlotsContainer.innerHTML = '';
          return;
        }

        fetch(`fetch_time_slots.php?date=${selectedDate}&venue_id=${selectedVenueId}`)
          .then(response => {
            if (!response.ok) {
              throw new Error('Network response was not ok');
            }
            return response.json();
          })
          .then(data => {
            if (data.length === 0) {
              showAlert('No available time slots for the selected date. Kindly choose another day. ');
            }

            availableTimeSlotsContainer.innerHTML = '';

            const allTimeSlots = [
              { slot_id: 'A', time_slot: '8:00 - 10:00' },
              { slot_id: 'B', time_slot: '10:00 - 12:00' },
              { slot_id: 'C', time_slot: '12:00 - 14:00' },
              { slot_id: 'D', time_slot: '14:00 - 16:00' },
              { slot_id: 'E', time_slot: '16:00 - 18:00' },
              { slot_id: 'F', time_slot: '18:00 - 20:00' },
              { slot_id: 'G', time_slot: '20:00 - 22:00' }
            ];

            const availableSlotIds = data.map(slot => slot.slot_id);

            allTimeSlots.forEach(timeSlot => {
              if (availableSlotIds.includes(timeSlot.slot_id)) {
                const timeSlotLabel = document.createElement('label');
                timeSlotLabel.classList.add('time-slot');
                timeSlotLabel.innerHTML = `<input type="radio" name="time_slot" value="${timeSlot.slot_id}"> <span>${timeSlot.time_slot}</span>`;
                availableTimeSlotsContainer.appendChild(timeSlotLabel);
              }
            });
          })
          .catch(error => {
            console.error('Error fetching time slots:', error);
            showAlert('Error fetching time slots. Please try again later.');
          });
      }

      function showAlert(message) {
        const alertElement = document.createElement('div');
        alertElement.classList.add('alert');
        alertElement.textContent = message;
        form.insertBefore(alertElement, form.firstChild);
      }

      function clearAlerts() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => alert.remove());
      }

      dateInput.addEventListener('change', updateTimeSlots);

      form.addEventListener('submit', function(event) {
        const selectedTimeSlot = document.querySelector('input[name="time_slot"]:checked');
        if (!selectedTimeSlot) {
          event.preventDefault();
          showAlert('Please select a time slot.');
        } else {
          document.getElementById('submitBtn').setAttribute('disabled', 'disabled');
        }
      });
    });
  </script>
  <script src="navi_bar.js"></script>
</body>
</html>



