<?php

define('BASE_PATH', __DIR__);
ob_start();

date_default_timezone_set('Asia/Manila');
session_start();

require_once __DIR__ . '/app/core/ErrorHandler.php';
ErrorHandler::register(); // early fallback

require_once __DIR__ . '/app/bootstrap/autoload.php';
require_once __DIR__ . '/app/core/Router.php';

// Make sure the exception class is loaded.
// If your autoload.php already loads it, you can remove this require_once.
require_once __DIR__ . '/app/exceptions/DatabaseConnectionException.php';

helpers();

$uri  = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($uri, PHP_URL_PATH) ?? '/';

$scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
if ($scriptDir !== '' && $scriptDir !== '/') {
    if (strpos($path, $scriptDir) === 0) {
        $path = substr($path, strlen($scriptDir));
    }
}

$path = '/' . ltrim($path, '/');
if ($path === '//') $path = '/';

$router = new Router();

try {

    // Force DB connection early if you want DB errors immediately.
    // (If you don't need early connection, you can remove this and let controllers hit DB when needed.)
    Database::pdo();

    $router->dispatch($path);
} catch (DatabaseConnectionException $e) {

    // Uses your adapted Router::renderError() logic inside the exception
    $e->render();
} catch (Throwable $e) {

    // Any other unexpected error -> your standard error page
    $router->renderError(
        500,
        'Server Error',
        'Something went wrong while processing your request.',
        $e->getMessage() . " in {$e->getFile()}:{$e->getLine()}"
    );
    exit;
}
