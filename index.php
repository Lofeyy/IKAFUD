<?php
// Start the session if you'll be using session variables
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>IKAFUD - Popular Easy to Cook Recipes</title>
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
      margin: auto;
      padding: 20px;
    }

    .search-bar {
      display: flex;
      margin-bottom: 20px;
    }

    .search-bar input {
      flex-grow: 1;
      margin-right: 10px;
      padding: 10px;
      border: 1px solid #FF6B6B;
      border-radius: 4px;
    }

    .search-bar button {
      background-color: #FF6B6B;
      color: white;
      border: none;
      padding: 10px;
      border-radius: 4px;
      cursor: pointer;
      width: 100px;
    }

    .meal-list {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      grid-gap: 20px;
    }

    .meal {
      background-color: #FFCDD2;
      border-radius: 4px;
      padding: 10px;
      text-align: center;
    }

    .meal img {
      max-width: 100%;
      height: 150px;
      object-fit: cover;
      border-radius: 4px;
    }

    footer {
      background-color: #FF6B6B;
      color: white;
      padding: 10px;
      text-align: center;
    }

    /* Modal styles */
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.4);
      padding-top: 60px;
    }

    .modal-content {
      background-color: #fefefe;
      margin: 5% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close:hover,
    .close:focus {
      color: black;
      text-decoration: none;
      cursor: pointer;
    }

    .add-favorite {
      background: none;
      border: none;
      color: #FF6B6B;
      font-size: 24px; /* Size of the star */
      cursor: pointer;
      margin-top: 10px;
    }

    .add-favorite:hover {
      color: #FF0000; /* Change color on hover */
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
    <h2>Search for a Meal</h2>
    <div class="search-bar">
      <input type="text" id="mealSearch" placeholder="Enter meal name">
      <button id="searchMeal">Search</button>
    </div>

    <div class="meal-list" id="mealList"></div>
  </div>

  <footer>
    <p>&copy; <?php echo date("Y"); ?> IKAFUD. All rights reserved.</p>
  </footer>

  <div id="recipeModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h3 id="modalMealName"></h3>
      <img id="modalMealImage" src="" alt="" style="width: 100%;">
      <h4>Ingredients:</h4>
      <ul id="modalIngredients"></ul>
      <h4>Instructions:</h4>
      <p id="modalInstructions"></p>
    </div>
  </div>

  <script>
    document.getElementById('searchMeal').addEventListener('click', function() {
      const mealName = document.getElementById('mealSearch').value;
      fetchMeals(mealName);
    });

    function fetchMeals(mealName) {
      const apiUrl = `https://www.themealdb.com/api/json/v1/1/search.php?s=${mealName}`;
      fetch(apiUrl)
        .then(response => response.json())
        .then(data => displayMeals(data.meals))
        .catch(error => console.error('Error fetching meals:', error));
    }

    function displayMeals(meals) {
      const mealList = document.getElementById('mealList');
      mealList.innerHTML = ''; // Clear previous results

      if (!meals) {
        mealList.innerHTML = '<p>No meals found.</p>';
        return;
      }

      meals.forEach(meal => {
        const mealDiv = document.createElement('div');
        mealDiv.className = 'meal';
        
        // Extract ingredients
        const ingredients = [];
        for (let i = 1; i <= 20; i++) {
          const ingredient = meal[`strIngredient${i}`];
          const measure = meal[`strMeasure${i}`];
          if (ingredient) {
            ingredients.push(`${measure} ${ingredient}`);
          }
        }
        
        // Create instructions
        const instructions = meal.strInstructions;

        mealDiv.innerHTML = `
          <img src="${meal.strMealThumb}" alt="${meal.strMeal}">
          <h3>${meal.strMeal}</h3>
          <p>Category: ${meal.strCategory}</p>
          <p>Area: ${meal.strArea}</p>
          <button class="add-favorite" data-meal="${meal.strMeal}">&#9733;</button> <!-- Star icon -->
          <a href="recipe.php?name=${encodeURIComponent(meal.strMeal)}&image=${encodeURIComponent(meal.strMealThumb)}&ingredients=${encodeURIComponent(ingredients.join(';'))}&instructions=${encodeURIComponent(instructions)}">View Full Recipe</a>
        `;
        mealList.appendChild(mealDiv);
      });

      // Add event listeners for favorite buttons
      document.querySelectorAll('.add-favorite').forEach(button => {
        button.addEventListener('click', function() {
          const mealName = this.getAttribute('data-meal');
          addToFavorites(mealName);
        });
      });
    }

    function addToFavorites(mealName) {
  fetch('add_to_favorites.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({ meal: mealName })
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert(`${mealName} has been added to your favorites!`);
    } else {
      alert(`${mealName} is already in your favorites.`);
    }
  })
  .catch(error => console.error('Error:', error));
}
  </script>
</body>
</html>