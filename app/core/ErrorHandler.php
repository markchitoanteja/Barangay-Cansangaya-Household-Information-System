<?php

class ErrorHandler
{
    private static bool $handling = false;

    /** @var callable|null */
    private static $renderer = null;

    public static function register(?callable $renderer = null): void
    {
        self::$renderer = $renderer;

        error_reporting(E_ALL);
        ini_set('display_errors', '0');
        ini_set('log_errors', '1');

        set_exception_handler([self::class, 'handleException']);
        set_error_handler([self::class, 'handleError']);
        register_shutdown_function([self::class, 'handleShutdown']);
    }

    public static function handleException(Throwable $e): void
    {
        if (!self::$handling) {
            self::$handling = true;
            self::logThrowable($e);
        }

        if (!headers_sent()) {
            http_response_code(500);
        }

        // prevent partial output from breaking your HTML error page
        while (ob_get_level() > 0) {
            @ob_end_clean();
        }

        // GUI render if available
        if (is_callable(self::$renderer)) {
            try {
                call_user_func(self::$renderer, $e);
            } catch (Throwable $renderFail) {
                // fallback
                echo "An unexpected error occurred.";
            }
        } else {
            echo "An unexpected error occurred.";
        }

        exit;
    }

    public static function handleError(int $severity, string $message, string $file, int $line): bool
    {
        if (!(error_reporting() & $severity)) {
            return true;
        }

        self::writeLogSafe(self::formatPhpError($severity, $message, $file, $line));
        throw new ErrorException($message, 0, $severity, $file, $line);
    }

    public static function handleShutdown(): void
    {
        $error = error_get_last();
        if ($error === null) return;

        $fatalTypes = [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR];
        if (!in_array($error['type'], $fatalTypes, true)) return;

        $msg = "[" . date('Y-m-d H:i:s') . "] "
            . "FATAL(" . $error['type'] . "): " . $error['message']
            . " | File: " . $error['file']
            . " | Line: " . $error['line']
            . PHP_EOL;

        self::writeLogSafe($msg);

        if (!headers_sent()) {
            http_response_code(500);
        }

        while (ob_get_level() > 0) {
            @ob_end_clean();
        }

        if (is_callable(self::$renderer)) {
            try {
                call_user_func(self::$renderer, new ErrorException(
                    $error['message'],
                    0,
                    $error['type'],
                    $error['file'],
                    $error['line']
                ));
            } catch (Throwable $renderFail) {
                echo "A fatal error occurred.";
            }
        } else {
            echo "A fatal error occurred.";
        }

        exit;
    }

    // ---------------- your existing helpers below ----------------

    private static function logThrowable(Throwable $e): void
    {
        $msg = "[" . date('Y-m-d H:i:s') . "] "
            . get_class($e) . ": " . $e->getMessage()
            . " | File: " . $e->getFile()
            . " | Line: " . $e->getLine()
            . PHP_EOL
            . $e->getTraceAsString()
            . PHP_EOL;

        self::writeLogSafe($msg);
    }

    private static function formatPhpError(int $severity, string $message, string $file, int $line): string
    {
        return "[" . date('Y-m-d H:i:s') . "] "
            . self::friendlyErrorType($severity) . ": " . $message
            . " | File: " . $file
            . " | Line: " . $line
            . PHP_EOL;
    }

    private static function friendlyErrorType(int $type): string
    {
        return match ($type) {
            E_ERROR => 'E_ERROR',
            E_WARNING => 'E_WARNING',
            E_PARSE => 'E_PARSE',
            E_NOTICE => 'E_NOTICE',
            E_CORE_ERROR => 'E_CORE_ERROR',
            E_CORE_WARNING => 'E_CORE_WARNING',
            E_COMPILE_ERROR => 'E_COMPILE_ERROR',
            E_COMPILE_WARNING => 'E_COMPILE_WARNING',
            E_USER_ERROR => 'E_USER_ERROR',
            E_USER_WARNING => 'E_USER_WARNING',
            E_USER_NOTICE => 'E_USER_NOTICE',
            E_STRICT => 'E_STRICT',
            E_RECOVERABLE_ERROR => 'E_RECOVERABLE_ERROR',
            E_DEPRECATED => 'E_DEPRECATED',
            E_USER_DEPRECATED => 'E_USER_DEPRECATED',
            default => 'E_UNKNOWN',
        };
    }

    private static function writeLogSafe(string $msg): void
    {
        $logFile = self::logFilePath();
        $logDir  = dirname($logFile);

        $prev = set_error_handler(fn() => true);

        try {
            if (!is_dir($logDir)) {
                @mkdir($logDir, 0777, true);
            }

            $ok = @file_put_contents($logFile, $msg, FILE_APPEND | LOCK_EX);

            if ($ok === false) {
                error_log("ErrorHandler: failed to write to $logFile");
                error_log($msg);
            }
        } finally {
            if ($prev !== null) {
                set_error_handler($prev);
            } else {
                restore_error_handler();
            }
        }
    }

    private static function logFilePath(): string
    {
        $root = defined('BASE_PATH') ? BASE_PATH : dirname(__DIR__, 3);
        return $root . DIRECTORY_SEPARATOR . 'logs' . DIRECTORY_SEPARATOR . 'error.log';
    }
}
