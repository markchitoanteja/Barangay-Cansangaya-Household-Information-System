<?php

if (!function_exists('dd')) {
    function dd(mixed $value): void
    {
        echo '<pre>';
        var_dump($value);
        echo '</pre>';
        exit;
    }
}
