<?php
session_start();

// Handle meal deletion
if (isset($_GET['remove'])) {
    $mealToRemove = $_GET['remove'];
    if (isset($_SESSION['favorites'])) {
        $_SESSION['favorites'] = array_diff($_SESSION['favorites'], [$mealToRemove]);
    }
    header("Location: favorites.php"); // Redirect to the favorites page to reflect changes
    exit;
}

// Handle session destruction
if (isset($_GET['clear'])) {
    session_destroy(); // Destroy the session
    header("Location: favorites.php"); // Redirect to favorites page
    exit;
}

// Retrieve favorites from session
$favorites = isset($_SESSION['favorites']) ? $_SESSION['favorites'] : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Your Favorites</title>
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

    nav ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
      display: flex;
    }

    nav ul li {
      margin-left: 20px;
    }

    nav ul li a {
      color: white;
      text-decoration: none;
      transition: color 0.3s;
      font-weight: bold;
    }

    nav ul li a:hover {
      color: #FFCDD2;
    }

    .container {
      max-width: 800px;
      margin: auto;
      padding: 20px;
    }

    h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .meal {
      background-color: #FFCDD2;
      border-radius: 8px;
      padding: 15px;
      margin-bottom: 20px;
      display: flex; 
      align-items: center;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.2s;
    }

    .meal:hover {
      transform: translateY(-5px);
    }

    .meal img {
      width: 80px; 
      height: auto; 
      border-radius: 8px;
      margin-right: 15px; 
    }

    .meal h3 {
      flex-grow: 1; 
      margin: 0;
    }

    .view-recipe, .remove-favorite {
      display: inline-block;
      background-color: #FF6B6B;
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 4px;
      text-decoration: none;
      margin-left: 10px;
    }

    .view-recipe:hover, .remove-favorite:hover {
      background-color: #FF0000;
    }

    @media (max-width: 600px) {
      .meal {
        flex-direction: column; 
        align-items: flex-start; 
      }

      .meal img {
        margin-bottom: 10px; 
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
                <li><a href="signup.php">Sign Up</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </div>
</header>
  
<div class="container">
    <h2>Your Favorite Meals</h2>
    <div id="mealList"></div>
    <div style="text-align: center;">
        <a href="?clear=true" class="remove-favorite" onclick="return confirm('Are you sure you want to clear all favorites?');">Clear All Favorites</a>
    </div>
</div>

<script>
    const favorites = <?php echo json_encode($favorites); ?>; // Pass PHP favorites to JavaScript

    function displayMeals(meals) {
        const mealList = document.getElementById('mealList');
        mealList.innerHTML = ''; // Clear previous results

        if (!meals.length) {
            mealList.innerHTML = '<p>No favorites added yet.</p>';
            return;
        }

        meals.forEach(meal => {
            const mealDiv = document.createElement('div');
            mealDiv.className = 'meal';

            // Make an API call to get meal details
            fetch(`https://www.themealdb.com/api/json/v1/1/search.php?s=${encodeURIComponent(meal)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.meals) {
                        const mealData = data.meals[0]; // Get the first meal from the result
                        
                        // Extract ingredients
                        const ingredients = [];
                        for (let i = 1; i <= 20; i++) {
                            const ingredient = mealData[`strIngredient${i}`];
                            const measure = mealData[`strMeasure${i}`];
                            if (ingredient) {
                                ingredients.push(`${measure} ${ingredient}`);
                            }
                        }

                        // Extract instructions
                        const instructions = mealData.strInstructions;

                        // Create meal HTML
                        mealDiv.innerHTML = `
                            <img src="${mealData.strMealThumb}" alt="${mealData.strMeal}">
                            <h3>${mealData.strMeal}</h3>
                            <a href="recipe.php?name=${encodeURIComponent(mealData.strMeal)}&image=${encodeURIComponent(mealData.strMealThumb)}&ingredients=${encodeURIComponent(ingredients.join(';'))}&instructions=${encodeURIComponent(instructions)}" class="view-recipe">View Full Recipe</a>
                            <a href="?remove=${encodeURIComponent(meal)}" class="remove-favorite">Remove</a> <!-- Remove button -->
                        `;
                        mealList.appendChild(mealDiv);
                    }
                })
                .catch(error => console.error('Error fetching meal details:', error));
        });
    }

    // Display the favorite meals
    displayMeals(favorites);
</script>
</body>
</html>