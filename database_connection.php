<?php
session_start(); // Start the session

$servername = "localhost"; // Server name
$username = "root"; // Default username
$password = ""; // Default password (blank for local installations)
$dbname = "ikafud"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>