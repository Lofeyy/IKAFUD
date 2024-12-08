<?php
session_start();

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
        $_SESSION['favorites'][] = $mealName; // Add to favorites
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => "$mealName is already in your favorites."]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No meal provided.']);
}
?>