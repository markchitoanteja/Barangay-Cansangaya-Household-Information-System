<?php

if (!function_exists('base_url')) {
    function base_url(string $path = ''): string
    {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host   = $_SERVER['HTTP_HOST'] ?? 'localhost';

        // adjust if app lives in a subfolder
        $scriptDir = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

        return rtrim("{$scheme}://{$host}{$scriptDir}", '/') . '/' . ltrim($path, '/');
    }
}

if (!function_exists('site_url')) {
    function site_url(string $path = ''): string
    {
        return base_url($path);
    }
}
