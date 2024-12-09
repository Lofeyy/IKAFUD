<?php
session_start();
require 'database_connection.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Prepare and execute the SQL statement
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Registration successful! You can now log in.";
        header("Location: login.php");
    } else {
        $_SESSION['error'] = "Error: " . $stmt->error;
        header("Location: signup.php");
    }

    $stmt->close();
}
?>