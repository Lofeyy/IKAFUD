<?php
session_start();
include 'database_connection.php'; // Include the database connection

// Get the posted data
$data = json_decode(file_get_contents("php://input"), true);
$mealName = $data['meal'] ?? null;

if ($mealName) {
    // Initialize favorites in session if not already set
    if (!isset($_SESSION['favorites'])) {
        $_SESSION['favorites'] = [];
    }

    // Debugging: Print current favorites
    error_log("Current favorites: " . json_encode($_SESSION['favorites']));

    // Check if the meal is already in favorites
    if (!in_array($mealName, $_SESSION['favorites'])) {
        // Add to session favorites
        $_SESSION['favorites'][] = $mealName;

        // Insert into the database
        $userId = $_SESSION['user_id']; // Assuming user_id is stored in session
        $stmt = $conn->prepare("INSERT INTO favorites (user_id, meal_name) VALUES (?, ?)");
        $stmt->bind_param("is", $userId, $mealName); // "is" means integer and string

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => "$mealName has been added to your favorites."]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $stmt->error]);
        }

        $stmt->close(); // Close the statement
    } else {
        echo json_encode(['success' => false, 'message' => "$mealName is already in your favorites."]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No meal provided.']);
}

// Close the database connection
$conn->close();
?>