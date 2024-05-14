<?php
require_once __DIR__ . "/loader.php";

use Controllers\AuthController;
use Controllers\AnswerController;

error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_start();

$method = $_SERVER['REQUEST_METHOD'];
$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$endpoint = $uri_parts[0];
$query_string = isset($uri_parts[1]) ? $uri_parts[1] : null;
if ($query_string != null) {
    parse_str($query_string, $params);
} else {
    $params = [];
}
//echo "Method: " . $method . "\n";
//echo "Path info: " . $endpoint . "\n";

if (str_starts_with($endpoint, "/api")) {
    switch ($endpoint) {
        case "/api/question":
            echo "Method: " . $method . "\n";
            echo "Path info: " . $endpoint . "\n";
            switch ($method) {
                case "GET":
                    if (isset($params['id'])) {
                        echo "Params: " . $params['id'] . "\n";
                        // TODO: Retrieve question by id
                    } elseif (isset($params['code'])) {
                        echo "Params: " . $params['code'] . "\n";
                        // TODO: Retrieve question by code
                    } else {
                        // TODO: Retrieve all questions
                    }
                    break;
                case "POST":
                    // TODO: Create new question
                    break;
                default:
                    http_response_code(405);
                    echo json_encode(["error" => "Method not allowed"]);
                    break;
            }
            break;
        case "/api/option":
            // Handle option-related requests
            break;
        default:
            http_response_code(404);
            $response = new stdClass();
            $response->code = 404;
            $response->message = "Not Found";
            $response->description = "The request resource was not found on this server";
            echo json_encode($response);
    }
} else if ($endpoint == "/login") {
    $controller = new AuthController();
    switch ($method) {
        case "GET":
            $controller->loginIndex();
            break;
        case "POST":
            $controller->login();
            break;
        case "DELETE":
            $controller->logout();
            break;
    }
} else if ($endpoint == "/register") {
    $controller = new AuthController();
    switch ($method) {
        case "GET":
            $controller->registerIndex();
            break;
        case "POST":
            $controller->register();
            break;
    }
} else if ($endpoint == "/user") {
    $controller = new AuthController();
    switch ($method){
        case "PUT":
            $controller->changePassword();
            break;
    }
} else if($endpoint == "/session") {
    $controller = new AuthController();
    switch ($method) {
        case "GET":
            $controller->getSessionInfo();
            break;
    }
} else if(preg_match('/^\/([A-Za-z0-9]{3})(?:|-)([A-Za-z0-9]{3})$/', $endpoint, $matches)){
    $code = $matches[1] . $matches[2];
    $controller = new AnswerController();
    switch ($method) {
        case "GET":
            $controller->index($code);
            break;
    }
}
?>
