<?php

if (!function_exists('redirect')) {
    function redirect(string $path): void
    {
        if (!str_starts_with($path, 'http')) {
            $path = base_url($path);
        }

        header("Location: {$path}");
        exit;
    }
}

if (!function_exists('json')) {
    function json(array $data, int $status = 200): void
    {
        http_response_code($status);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}
