<?php

if (!function_exists('input')) {
    function input(string $key, mixed $default = null): mixed
    {
        return $_POST[$key] ?? $_GET[$key] ?? $default;
    }
}

if (!function_exists('is_post')) {
    function is_post(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
    }
}

if (!function_exists('is_get')) {
    function is_get(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET';
    }
}

if (!function_exists('input_file')) {
    function input_file(string $key, mixed $default = null): mixed
    {
        if (!isset($_FILES[$key])) {
            return $default;
        }

        $file = $_FILES[$key];

        // Handle both single and multiple file inputs
        if (is_array($file['name'])) {
            return $file; // return raw array for multiple files
        }

        // Single file: return only if upload is valid
        return $file['error'] === UPLOAD_ERR_OK ? $file : $default;
    }
}
