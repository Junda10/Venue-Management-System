
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="navi_bar_white.css">

<style>
    	
body {
  font-family: 'Raleway', sans-serif;
  height: 100vh;
  display: flex;
  align-items: center;
  font-weight: 300;
  background-image: url('images/Wallpaper2.jpg');
  background-size: cover; 
  background-position: center; 
  background-repeat: no-repeat; 
  background-attachment: fixed;
  flex-direction: column;
  overflow: hidden;

}
       
.all {
  display: flex;
  perspective: 10px;
  transform: perspective(300px) rotateX(20deg);
  will-change: perspective;
  perspective-origin: center center;
  transition: all 1.3s ease-out;
  justify-content: center;
  transform-style: preserve-3d;
  align-items: center;
  height: 100vh; 
  
}
.all:hover {
  perspective: 1000px;
  transition: all 1.3s ease-in;
  transform: perspective(10000px) rotateX(0deg);
  .text {
    opacity: 1;
  }
  & > div {
    opacity: 1;
    transition-delay: 0s;
  }
  .explainer {
    opacity: 0;
  }
}

.left, .center, .right, .lefter, .righter {
  width: 200px;
  height: 150px;
  transform-style: preserve-3d;
  border-radius: 10px;
  border: 1px solid #fff;
  box-shadow: 0 0 20px 5px rgba(100, 100, 255, .4);
  opacity: 0;
  transition: all .3s ease;
  transition-delay: 1s;
  position: relative;
  background-position: center center;
  background-size: contain;
  background-repeat: no-repeat;
  background-color: #58d;
  cursor: pointer;
  background-blend-mode: color-burn;
  
  &:hover {
    box-shadow: 0 0 30px 10px rgba(100, 100, 255, .6);
  background-color: #ccf;
  }
}
.text {
  transform: translateY(30px);
  opacity: 0;
  transition: all .3s ease;
  bottom: 0;
  left: 5px;
  position: absolute;
  will-change: transform;
  color: #fff;
  text-shadow: 0 0 5px rgba(100, 100, 255, .6)
}
.lefter {
  transform: translateX(-60px) translateZ(-50px) rotateY(-10deg);
  background-image: url('images/ViewReservation.jpg');
}
.left {
  transform: translateX(-30px) translateZ(-25px) rotateY(-5deg);
  background-image: url('images/viewvenue.png');
}
.center {
  opacity: 1;
  background-image: url('images/UserInfo.jpg');
}

.right {
  transform: translateX(30px) translateZ(-25px) rotateY(5deg);
  background-image: url('images/admin_profile.png');
}
.righter {
  transform: translateX(60px) translateZ(-50px) rotateY(10deg);
  background-image: url('images/logout.jpg');
}
.explainer {
  font-weight: 300;
  font-size: 2rem;
  color: #fff;
  height: 100%;
  background-color: #303050;
  border-radius: 10px;
  text-shadow: 0 0 10px rgba(255, 255, 255, .8);
  display: flex;
  justify-content: center;
  align-items: center;
}


.ref {
  background-color: #000;
  background-image: linear-gradient(to bottom, #d80, #c00);
  border-radius: 3px;
  padding: 7px 10px;
  position: absolute;
  font-size: 16px;
  bottom: 10px;
  right: 10px;
  color: #fff;
  text-decoration: none;
  text-shadow: 0 0 3px rgba(0, 0, 0, .4);
  &::first-letter {
    font-size: 12px;
  }
}

</style>

</head>

<div class="all">

  <div class="lefter" onclick="location.href='admin_reservation_menu.php'">
    <div class="text">View Reservation</div>
  </div>
  <div class="left" onclick="location.href='admin_display_venue.php'">
    <div class="text">View Venue</div>
  </div>
  <div class="center" onclick="location.href='admin_system_info_menu.php'">
    <div class="explainer"><span>ADMIN<br> MENU</span></div>
    <div class="text">Admin & User Information</div>
  </div>
  <div class="right" onclick="location.href='admin_profile.php'">
    <div class="text">Admin Profile</div>
  </div>
  <div class="righter" onclick="location.href='logout.php'">
    <div class="text">Log Out</div>
  </div>
  

</body>
</html>

<style>

</style>