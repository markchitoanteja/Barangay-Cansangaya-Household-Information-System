<?php
date_default_timezone_set('Asia/Manila');

session_start();

require_once 'app/core/Router.php';
require_once 'app/bootstrap/autoload.php';

helpers();

// Resolve request path
$uri  = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$base = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

if ($base !== '' && $base !== '/' && str_starts_with($uri, $base)) {
    $uri = substr($uri, strlen($base));
}

$path = '/' . ltrim($uri, '/');   // always starts with "/"
if ($path === '//') $path = '/';

// Dispatch request
$router = new Router();
$router->dispatch($path);
