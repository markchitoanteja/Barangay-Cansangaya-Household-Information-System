<?php

/*
|--------------------------------------------------------------------------
| AUTOLOAD CORE CLASSES
|--------------------------------------------------------------------------
*/

spl_autoload_register(function ($class) {

    $paths = [
        BASE_PATH . '/system/core/',
        BASE_PATH . '/system/controllers/',
        BASE_PATH . '/app/models/',
    ];

    foreach ($paths as $path) {

        $file = $path . $class . '.php';

        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});


/*
|--------------------------------------------------------------------------
| AUTOLOAD HELPERS
|--------------------------------------------------------------------------
*/

function helpers(array $helpers = []): void
{
    $helpersDir = __DIR__ . '/../helpers/';

    // Load all helpers
    if (empty($helpers)) {
        foreach (glob($helpersDir . '*_helper.php') as $file) {
            require_once $file;
        }
        return;
    }

    // Load specific helpers
    foreach ($helpers as $helper) {

        $file = $helpersDir . $helper . '_helper.php';

        if (file_exists($file)) {
            require_once $file;
        } else {
            throw new RuntimeException("Helper not found: {$helper}");
        }
    }
}
