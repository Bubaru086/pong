<?php

require_once '_init.php';

    // Check if a POST request with JSON data is received
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SERVER["CONTENT_TYPE"]) && $_SERVER["CONTENT_TYPE"] == "application/json") {
        // Decode the JSON data
        $data = json_decode(file_get_contents("php://input"), true);
    
        // Check if the 'unit' variable is present in the JSON data
        if (isset($data['deltaTime'])) {
            // Assign the 'unit' value to the session variable
            $deltaTime = $data['deltaTime'];
            $_SESSION['game']->update($deltaTime);
        }

    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getGameState') {
        header('Content-Type: application/json');

        $gameValues = $_SESSION['game']->getData();
        echo json_encode($gameValues);

        exit();
    }

