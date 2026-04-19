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

if (!function_exists('set_env_value')) {
    function set_env_value(string $key, string $value): void
    {
        $envPath = BASE_PATH . '/.env';

        if (!file_exists($envPath)) return;

        $content = file_get_contents($envPath);

        $pattern = "/^{$key}=.*/m";

        if (preg_match($pattern, $content)) {
            $content = preg_replace($pattern, "{$key}={$value}", $content);
        } else {
            $content .= "\n{$key}={$value}\n";
        }

        file_put_contents($envPath, $content);
    }
}
