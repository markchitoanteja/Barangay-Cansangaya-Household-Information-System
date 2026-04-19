<?php

define('BASE_PATH', __DIR__);
ob_start();

date_default_timezone_set('Asia/Manila');
session_start();

require_once __DIR__ . '/system/core/ErrorHandler.php';
ErrorHandler::register(); // early fallback

require_once __DIR__ . '/system/bootstrap/autoload.php';
require_once __DIR__ . '/system/core/Router.php';
require_once __DIR__ . '/system/exceptions/DatabaseConnectionException.php';

helpers();

// Normalize request URI
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
    if (env('DB_CHANGESETTINGS') === 'true') {
        $seedModel = new Seed_Database_Model();

        // 1. Drop all tables
        $seedModel->dropAllTables();

        // 2. Re-run full seed
        $seedModel->MOD_SEED_DATABASE();

        // 3. Turn OFF the flag (important to prevent loop)
        set_env_value('DB_CHANGESETTINGS', 'false');
    }

    // --- 1. Force DB connection early ---
    $pdo = Database::pdo();

    // --- 2. Seed database if not already seeded ---
    $seedModel = new Seed_Database_Model();

    if (!$seedModel->is_seeded()) {  // Make sure you implement is_seeded() in your model
        $seedModel->MOD_SEED_DATABASE();
    }

    // --- 3. Dispatch router ---
    $router->dispatch($path);
} catch (DatabaseConnectionException $e) {
    // Handle DB connection errors
    $e->render();
} catch (Throwable $e) {
    // Handle all other errors
    $router->renderError(
        500,
        'Server Error',
        'Something went wrong while processing your request.',
        $e->getMessage() . " in {$e->getFile()}:{$e->getLine()}"
    );
    exit;
}
