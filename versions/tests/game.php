<?php
namespace Pong;

class Game {

    public function __construct() {
        
    }

    
}



/*

    if (!isset($_SESSION['canvasHeight'])) {
        $_SESSION['canvasHeight'] = 540;
    }

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
    
        echo $_SESSION['obstaclesBool'];
    }

*/








/*

// Initialize game state if not already set
if (!isset($_SESSION['game_state'])) {
    $_SESSION['game_state'] = array(
        'scoreOne' => 0,
        'scoreTwo' => 0,
        // Other game state variables here
    );
}

if (!isset($_SESSION['scoreOne'])) {
    $_SESSION['scoreOne'] = 0;
}

// API endpoint to get game state
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getGameState') {
    header('Content-Type: application/json');
    echo json_encode($_SESSION['scoreOne']);
    exit();
}

// API endpoint to update game state
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'updateGameState') {
    // Update game state based on data sent from client
    // For example: $_SESSION['game_state']['scoreOne'] = $_POST['scoreOne'];
    // Ensure to validate and sanitize the data before updating the session
    // Return updated game state as JSON response
    header('Content-Type: application/json');
    echo json_encode($_SESSION['game_state']);
    exit();
}

// API endpoint to update game state
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'updateScoreOne') {
    // Update game state based on data sent from client
    // For example: $_SESSION['game_state']['scoreOne'] = $_POST['scoreOne'];
    $_SESSION['scoreOne']++;
    // Ensure to validate and sanitize the data before updating the session
    // Return updated game state as JSON response
    header('Content-Type: application/json');
    echo json_encode($_SESSION['scoreOne']);
    exit();
}

*/