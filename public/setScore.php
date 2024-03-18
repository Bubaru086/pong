<?php
session_start();

// Check if a POST request with JSON data is received
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SERVER["CONTENT_TYPE"]) && $_SERVER["CONTENT_TYPE"] == "application/json") {
    // Decode the JSON data
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['name']) && isset($data['score'])) {
            // Initialize leaderboard array if it doesn't exist in the session
        if (!isset($_SESSION['leaderboard'])) {
            $_SESSION['leaderboard'] = [];
        }

        // Add player's name and score to the leaderboard array
        $_SESSION['leaderboard'][] = [
            'name' => $data['name'],
            'score' => $data['score'],
        ];
    }

    echo var_dump($_SESSION['leaderboard']);
}

