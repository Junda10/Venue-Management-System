<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>University Venue Management System</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  margin: 0;
  padding: 0;
  width: 100%;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  font-family: 'Kreon', serif;
  overflow: hidden; /* Prevent scrolling */
  position: relative; /* Necessary for positioning the background */
}

.background {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-image: url('pic2.jpeg');
  background-size: cover; 
  background-position: center; 
  background-repeat: no-repeat; 
  filter: blur(5px) brightness(20%);
  z-index: -1; /* Ensure background is behind the text */
}

.render {
  font-weight: 700;
  font-size: 100px; /* Adjust the font size as needed */
  color: #f5f5f5;
  text-align: center;
  text-shadow:
    white 0.006em 0.006em 0.007em,
    #9c9c9c 1px 1px 1px,
    #9c9c9c 1px 2px 1px,
    #9c9c9c 1px 3px 1px,
    #9c9c9c 1px 4px 1px,
    #9c9c9c 1px 5px 1px,
    #9c9c9c 1px 6px 1px,
    #9c9c9c 1px 7px 1px,
    #9c9c9c 1px 8px 1px,
    #9c9c9c 1px 9px 1px,
    #9c9c9c 1px 10px 1px,
    #9c9c9c 1px 11px 1px,
    #9c9c9c 1px 12px 1px,
    rgba(16, 16, 16, 0.4) 1px 18px 6px,
    rgba(16, 16, 16, 0.2) 1px 22px 10px,
    rgba(16, 16, 16, 0.2) 1px 26px 35px,
    rgba(16, 16, 16, 0.4) 1px 30px 65px,
    white -0.15em -0.1em 100px;
  transition: all 0.3s ease;
}

.render:hover {
  margin-top: -20px;
  text-shadow:
    white 0.006em 0.006em 0.007em,
    #9c9c9c 1px 1px 1px,
    #9c9c9c 1px 2px 1px,
    #9c9c9c 1px 3px 1px,
    #9c9c9c 1px 4px 1px,
    #9c9c9c 1px 5px 1px,
    #9c9c9c 1px 6px 1px,
    #9c9c9c 1px 7px 1px,
    #9c9c9c 1px 8px 1px,
    #9c9c9c 1px 9px 1px,
    #9c9c9c 1px 10px 1px,
    #9c9c9c 1px 11px 1px,
    #9c9c9c 1px 12px 1px,
    rgba(16, 16, 16, 0.4) 1px 38px 26px,
    rgba(16, 16, 16, 0.2) 1px 42px 30px,
    rgba(16, 16, 16, 0.2) 1px 46px 65px,
    rgba(16, 16, 16, 0.4) 1px 50px 95px,
    white -0.15em -0.1em 100px;
}
</style>
</head>

<body>
<div class="background"></div>
<span class="render">University Venue <br> Management System</span>
</body>

</html>
