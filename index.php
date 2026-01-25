<?php
// Fix for Render 403 Forbidden Error
// Automatically redirect to the main entry point
header("Location: main.php");
exit();
?>