<?php
// Logout process
session_start();
session_destroy(); // Destroy the session
header("Location: Login.html");

// Clear the login cookie
$cookie_name = "user_logged_in";
setcookie($cookie_name, "", time() - 3600, "/"); // Set to past time to delete cookie
?>