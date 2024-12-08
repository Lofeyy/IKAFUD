<?php
// Start the session if you'll be using session variables
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IKAFUD - Login</title>
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
          <li><a href="signup.php">Sign Up</a></li>
          <li><a href="login.php">Login</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <div class="container">
    <h2>Login</h2>
    <form class="login-form" method="POST" action="login_handler.php">
      <label for="username">Username:</label>
      <input type="text" id="username" name="username" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">Login</button>
    </form>
  </div>

  <footer>
    <p>&copy; <?php echo date("Y"); ?> IKAFUD. All rights reserved.</p>
  </footer>

  <script src="login.js"></script>
</body>
</html>