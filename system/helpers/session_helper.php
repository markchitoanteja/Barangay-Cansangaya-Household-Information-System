<?php

/*
|--------------------------------------------------------------------------
| SET SESSION
|--------------------------------------------------------------------------
*/

if (!function_exists('session_set')) {
    function session_set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }
}


/*
|--------------------------------------------------------------------------
| GET SESSION
|--------------------------------------------------------------------------
*/

if (!function_exists('session_get')) {
    function session_get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }
}


/*
|--------------------------------------------------------------------------
| CHECK SESSION
|--------------------------------------------------------------------------
*/

if (!function_exists('session_has')) {
    function session_has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }
}


/*
|--------------------------------------------------------------------------
| REMOVE SESSION
|--------------------------------------------------------------------------
*/

if (!function_exists('session_remove')) {
    function session_remove(string $key): void
    {
        unset($_SESSION[$key]);
    }
}


/*
|--------------------------------------------------------------------------
| DESTROY SESSION
|--------------------------------------------------------------------------
*/

if (!function_exists('session_destroy_all')) {
    function session_destroy_all(): void
    {
        session_unset();
        session_destroy();
    }
}


/*
|--------------------------------------------------------------------------
| FLASH MESSAGE
|--------------------------------------------------------------------------
*/

if (!function_exists('flash')) {
    function flash(string $key, mixed $value): void
    {
        if (!isset($_SESSION['_flash'])) {
            $_SESSION['_flash'] = [];
        }

        $_SESSION['_flash'][$key] = $value;
    }
}


/*
|--------------------------------------------------------------------------
| GET FLASH MESSAGE
|--------------------------------------------------------------------------
*/

if (!function_exists('get_flash')) {
    function get_flash(string $key, mixed $default = null): mixed
    {
        if (!isset($_SESSION['_flash'])) {
            return $default;
        }

        $value = $_SESSION['_flash'][$key] ?? $default;

        unset($_SESSION['_flash'][$key]);

        return $value;
    }
}
