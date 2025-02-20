<?php
session_start(); // Start the session

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page or home page
header("Location: index-4.php"); // Replace with the page you want the user to be redirected to after logout
exit();
?>
