<?php
session_start(); // Start the session

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Optionally, set a message for the user about successful logout
session_start(); // Start a new session to set the message
// $_SESSION['message'] = "You have been logged out successfully.";

// Redirect to the home page
header("Location: index.php");
exit(); // Stop further execution
?>