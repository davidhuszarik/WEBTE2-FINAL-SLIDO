<?php
require_once __DIR__ . "/controllers/AuthController.php";
use Controllers\AuthController;

error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_start();

// header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$endpoint = $uri_parts[0];

//echo "Method: " . $method . "\n";
//echo "Path info: " . $endpoint . "\n";

if(str_starts_with($endpoint, "/api/test"))
{
//    if($endpoint == "/api/test"){
//
//    }
}
else if($endpoint == "/login")
{
    $controller = new AuthController();
    switch($method){
        case "GET":
            $controller->loginIndex();
            break;
        case "POST":
            $controller->login();
            break;
        case "DELETE":
            break;
    }
}
else if($endpoint == "/register")
{
    $controller = new AuthController();
    switch($method){
        case "GET":
            $controller->registerIndex();
            break;
        case "POST":
            $controller->register();
            break;
    }
}
?>
