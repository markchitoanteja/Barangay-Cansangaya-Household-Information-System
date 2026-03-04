<?php

require_once __DIR__ . '/../core/Env.php';

if (!function_exists('env')) {

    /**
     * Get environment variable
     *
     * Usage:
     * env('DB_HOST')
     * env('APP_NAME', 'My App')
     */
    function env(string $key, mixed $default = null): mixed
    {
        static $loaded = false;

        if (!$loaded) {
            Env::load(dirname(__DIR__, 2) . '/.env');
            $loaded = true;
        }

        return Env::get($key, $default);
    }
}
