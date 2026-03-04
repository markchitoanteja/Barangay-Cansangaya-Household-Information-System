<?php

date_default_timezone_set('Asia/Manila');
session_start();

/**
 * Register error handler FIRST so it can catch autoload/bootstrap errors too.
 */
require_once __DIR__ . '/app/core/ErrorHandler.php';
ErrorHandler::register();

/**
 * Load autoload + core router + helpers
 */
require_once __DIR__ . '/app/bootstrap/autoload.php';
require_once __DIR__ . '/app/core/Router.php';

helpers();

/**
 * Resolve request path (supports subfolder installs like /myproject)
 */
$uri  = $_SERVER['REQUEST_URI'] ?? '/';
$path = parse_url($uri, PHP_URL_PATH) ?? '/';

$scriptDir = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? '')), '/');
if ($scriptDir !== '' && $scriptDir !== '/') {
    // Remove base folder prefix if present
    if (strpos($path, $scriptDir) === 0) {
        $path = substr($path, strlen($scriptDir));
    }
}

$path = '/' . ltrim($path, '/');
if ($path === '//') {
    $path = '/';
}

/**
 * Dispatch request
 */
$router = new Router();
$router->dispatch($path);
