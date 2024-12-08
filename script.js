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