<?php
require_once __DIR__ . "/loader.php";

use Controllers\Controller;
use Controllers\AuthController;
use Controllers\AnswerController;
use Controllers\QuestionController;
use Controllers\ExportController;

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
} else if ($endpoint == "/question"){
    $controller = new QuestionController();
    $userId = (!empty($_GET['user_id']) && (int)$_GET['user_id'] != 0) ? (int)$_GET['user_id'] : null;
    switch ($method){
        case "GET":
            $controller->index($userId);
            break;
        case "POST":
            parse_str(file_get_contents("php://input"), $postData);
            $controller->createNewQuestion($userId, $postData);
            break;
    }
} else if(preg_match('/^\/question\/(\d+)$/', $endpoint, $matches)){
    $controller = new QuestionController();
    $questionId = $matches[1];
    switch ($method){
        case "GET":
            $controller->indexId($questionId);
            break;
        case "POST":
            parse_str(file_get_contents("php://input"), $postData);
            if (!empty($postData['is_open'])){
                if ($postData['is_open'] == "true" && !empty($postData['end_timestamp'])){
                    $controller->openById($questionId, $postData['end_timestamp']);
                }
                else if ($postData['is_open'] == "false"){
                    $controller->closeById($questionId );
                }
            }
            break;
        case "PUT":
            parse_str(file_get_contents("php://input"), $putData);
            $controller->updateQuestion($questionId, $putData);
            break;
        case "DELETE":
            $controller->deleteById($questionId);
            break;
    }
} else if (preg_match('/^\/question\/clone\/(\d+)$/', $endpoint, $matches)){
    $controller = new QuestionController();
    $questionId = $matches[1];
    switch ($method){
        case "POST":
            $controller->cloneQuestion($questionId);
            break;
    }
} else if(preg_match('/^\/([A-Za-z0-9]{3})(?:|-)([A-Za-z0-9]{3})$/', $endpoint, $matches)){
    $code = $matches[1] . $matches[2];
    $controller = new AnswerController();
    switch ($method) {
        case "GET":
            $controller->index($code);
            break;
        case "POST":
            parse_str(file_get_contents("php://input"), $postData);
            $controller->answer($code, $postData);
            break;
    }
} else if ($endpoint == "/export") {
    $controller = new ExportController();
    switch ($method) {
        case "GET":
            parse_str(file_get_contents("php://input"), $export_format);
            if (isset($export_format['format'])) {
                $controller->export($export_format['format']);
            } else {
                http_response_code(400);
                echo json_encode(["error" => "Format not specified"]);
            }
            break;
        default:
            http_response_code(405);
            echo json_encode(["error" => "Method not allowed"]);
            break;
    }
} else {
    /*
    $controller = new Controller();
    $controller->render("notExist");
    */
}
?>
