<?php

//echo "config";

$_SESSION['unit'] = 20;
$_SESSION['singleplayer'] = true;
$_SESSION['obstaclesBool'] = false;
$_SESSION['canvasHeight'] = 540;

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

    echo $_SESSION['unit'];
}

require_once('game.php');

/*

$GLOBALS["appDir"] = resolve_path("app");

function resolve_path($name)
{
    if ($name == ".")
    {
        $publicRoot = $_SERVER["DOCUMENT_ROOT"] . "/..";
        $appRoot = $_SERVER["DOCUMENT_ROOT"];
    }
    else if ($_SERVER["DOCUMENT_ROOT"] != "")
    {
        $publicRoot = $_SERVER["DOCUMENT_ROOT"] . "/../$name";
        $appRoot = $_SERVER["DOCUMENT_ROOT"] . "/$name";
    }
    else
    {
        return "../{$name}";
    }

    return file_exists($publicRoot) ? realpath($publicRoot) : realpath($appRoot);
}

spl_autoload_register(function ($fullName) {
    $parts = explode("\\", $fullName);
    $len = count($parts);
    $className = $parts[$len - 1];
    if (file_exists($GLOBALS["appDir"] . "/{$className}.php"))
    {
      require_once $GLOBALS["appDir"] . "/{$className}.php";
    }
});

*/