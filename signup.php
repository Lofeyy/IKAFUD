<?php
session_start();

// Optionally, check if the user is logged in
$is_logged_in = isset($_SESSION['user_id']);

if (isset($_SESSION['error'])) {
  echo "<p style='color:red;'>" . $_SESSION['error'] . "</p>";
  unset($_SESSION['error']);
}

if (isset($_SESSION['message'])) {
  echo "<p style='color:green;'>" . $_SESSION['message'] . "</p>";
  unset($_SESSION['message']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign Up - IKAFUD</title>
  <link rel="stylesheet" href="ikafud.css">
  <style>
    body {
      font-family: 'Arial', sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f9f9f9;
      color: #333;
      line-height: 1.6;
    }

    header {
      background-color: #FF6B6B;
      color: white;
      padding: 20px 0;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .header-content {
      max-width: 800px;
      margin: 0 auto;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    header nav ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
      display: flex;
    }

    header nav ul li {
      margin-left: 20px;
    }

    header nav ul li a {
      color: white;
      text-decoration: none;
      transition: color 0.3s;
      font-weight: bold;
    }

    header nav ul li a:hover {
      color: #FFCDD2;
    }

    .container {
      max-width: 400px;
      margin: auto;
      padding: 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      margin-top: 50px;
    }

    h2 {
      text-align: center;
      color: #FF6B6B;
    }

    input[type="text"], input[type="password"], input[type="email"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #FF6B6B;
      border-radius: 4px;
    }

    button {
      background-color: #FF6B6B;
      color: white;
      border: none;
      padding: 10px;
      border-radius: 4px;
      cursor: pointer;
      width: 100%;
    }

    button:hover {
      background-color: #FF4C4C;
    }

    footer {
      background-color: #FF6B6B;
      color: white;
      padding: 10px;
      text-align: center;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <header>
    <div class="header-content">
      <h1>IKAFUD</h1>
      <nav>
        <ul>
          <li><a href="index.php">Home</a></li>
          <li><a href="favorites.php">Favorites</a></li>
          <li><a href="login.php">Login</a></li>
          <li><a href="logout.php">Logout</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <div class="container">
    <h2>Sign Up</h2>
    <form action="signup_process.php" method="post">
      <input type="text" name="name" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Create Account</button>
    </form>
    <p style="text-align: center;">Already have an account? <a href="login.php">Log In</a></p>
  </div>

  <footer>
    <p>&copy; <?php echo date("Y"); ?> IKAFUD. All rights reserved.</p>
  </footer>
</body>
</html>