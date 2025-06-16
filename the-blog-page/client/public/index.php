<?php

declare(strict_types=1);

require_once __DIR__ . "/../vendor/autoload.php";

use App\Core\Request;
use App\Core\Router;
use Dotenv\Dotenv;

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$router = new Router();
require __DIR__ . '/../config/routes.php';

$request = new Request();
$request = $router->dispatch($request);
$request->send();