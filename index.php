<?php
session_start();

require_once 'app/core/Router.php';
require_once 'app/bootstrap/autoload.php';

helpers();

// Resolve request path
$uri  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base = dirname($_SERVER['SCRIPT_NAME']);

if ($base !== '/' && str_starts_with($uri, $base)) {
    $uri = substr($uri, strlen($base));
}

$route = trim($uri, '/');

// Dispatch request
$router = new Router();
$router->dispatch($route);
