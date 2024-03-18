<?php

require_once 'game.php';

$_SESSION['unit'] = 20;
$_SESSION['singleplayer'] = true;
$_SESSION['obstaclesBool'] = false;

    // Check if a POST request with JSON data is received
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SERVER["CONTENT_TYPE"]) && $_SERVER["CONTENT_TYPE"] == "application/json") {
        // Decode the JSON data
        $data = json_decode(file_get_contents("php://input"), true);
    
        // Check if the 'unit' variable is present in the JSON data
        if (isset($data['unit'])) {
            // Assign the 'unit' value to the session variable
            $_SESSION['unit'] = $data['unit'];
        }
        if (isset($data['singleplayer'])) {
            $_SESSION['singleplayer'] = $data['singleplayer'];
        }
        if (isset($data['obstaclesBool'])) {
            $_SESSION['obstaclesBool'] = $data['obstaclesBool'];
        }
    }

$_SESSION['game'] = new Game();
$_SESSION['game']->reset();