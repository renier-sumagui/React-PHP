<?php

require_once __DIR__ . "/../vendor/autoload.php";

use App\Core\Router;
use App\Core\Request;

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

$router = new Router();
require __DIR__ . '/../config/routes.php';

$request = new Request();
$response = $router->dispatch($request);
$response->send();