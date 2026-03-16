<?php

/**
 * Escape output for safe HTML rendering
 */
if (!function_exists('esc')) {
    function esc($value): string
    {
        if ($value === null) {
            return '';
        }

        return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
    }
}
