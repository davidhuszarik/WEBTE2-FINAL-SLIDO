<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

ob_start();

header("Content-Type: application/json");

$method = $_SERVER['REQUEST_METHOD'];
$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
$endpoint = $uri_parts[0];

//echo "Method: " . $method . "\n";
//echo "Path info: " . $endpoint . "\n";

//if(strpos($endpoint, "/api/test") === 0){
//    if($endpoint == "/api/test"){
//
//    }
//}
?>
