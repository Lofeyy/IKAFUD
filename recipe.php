<?php
// Start the session if you'll be using session variables
session_start();

// Optionally, check if the user is logged in
$is_logged_in = isset($_SESSION['user_id']);

// Get the meal data from the URL parameters
$mealName = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Meal not found';
$mealImage = isset($_GET['image']) ? htmlspecialchars($_GET['image']) : '';
$ingredients = isset($_GET['ingredients']) ? htmlspecialchars($_GET['ingredients']) : '';
$instructions = isset($_GET['instructions']) ? htmlspecialchars($_GET['instructions']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $mealName; ?> - IKAFUD</title>
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
      max-width: 800px;
      margin: 20px auto;
      padding: 20px;
      background: white;
      border-radius: 8px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .content {
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      align-items: flex-start;
      width: 100%;
    }

    .image-container {
      flex: 1;
      margin-right: 20px;
    }

    .ingredients-container {
      flex: 1;
    }

    h2 {
      text-align: center;
      color: #FF6B6B;
    }

    img {
      max-width: 100%;
      height: auto;
      border-radius: 8px;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    h4 {
      margin-top: 20px;
      color: #333;
    }

    ul {
      list-style-type: square;
      padding-left: 20px;
    }

    footer {
      background-color: #FF6B6B;
      color: white;
      padding: 10px;
      text-align: center;
      position: relative;
      bottom: 0;
      width: 100%;
    }

    @media (max-width: 600px) {
      .header-content {
        flex-direction: column;
        align-items: flex-start;
      }

      header nav ul {
        flex-direction: column;
      }

      header nav ul li {
        margin: 5px 0;
      }

      .content {
        flex-direction: column;
        align-items: center;
      }

      .image-container {
        margin-right: 0;
        margin-bottom: 20px;
      }
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
    <h2><?php echo $mealName; ?></h2>
    <div class="content">
      <div class="image-container">
        <img src="<?php echo $mealImage; ?>" alt="<?php echo $mealName; ?>">
      </div>
      <div class="ingredients-container">
        <h4>Ingredients:</h4>
        <ul>
          <?php
          $ingredientsArray = explode(';', $ingredients);
          foreach ($ingredientsArray as $ingredient) {
              echo "<li>" . htmlspecialchars($ingredient) . "</li>";
          }
          ?>
        </ul>
      </div>
    </div>

    <h4>Instructions:</h4>
    <div class='instruction-card'>
      <?php
      // Split the instructions into steps assuming they are separated by newlines
      $instructionSteps = explode("\n", $instructions);
      foreach ($instructionSteps as $step) {
          $step = trim($step); // Remove extra whitespace
          if ($step) { // Check if the step is not empty
              echo htmlspecialchars($step) . "<br><br>"; // Add a line break for spacing after each step
          }
      }
      ?>
    </div>
</div>

  <footer>
    <p>&copy; <?php echo date("Y"); ?> IKAFUD. All rights reserved.</p>
  </footer>
</body>
</html>