<?php

class ErrorHandler
{
    /**
     * Register all handlers.
     */
    public static function register(): void
    {
        // Report everything so the handler can catch it
        error_reporting(E_ALL);

        // Do not display errors to users (log instead)
        ini_set('display_errors', '0');

        set_exception_handler([self::class, 'handleException']);
        set_error_handler([self::class, 'handleError']);
        register_shutdown_function([self::class, 'handleShutdown']);
    }

    /**
     * Handles uncaught exceptions/throwables.
     */
    public static function handleException(Throwable $e): void
    {
        self::logThrowable($e);

        // If headers not sent, set 500
        if (!headers_sent()) {
            http_response_code(500);
        }

        // Keep response simple (you can replace with a view)
        echo "An unexpected error occurred.";

        exit;
    }

    /**
     * Converts PHP errors into ErrorException so they flow into handleException().
     *
     * Return true to tell PHP we handled the error.
     */
    public static function handleError(int $severity, string $message, string $file, int $line): bool
    {
        // Respect @ operator (suppressed errors)
        if (!(error_reporting() & $severity)) {
            return true;
        }

        throw new ErrorException($message, 0, $severity, $file, $line);
    }

    /**
     * Catches fatal errors on shutdown (E_ERROR, E_PARSE, etc.).
     */
    public static function handleShutdown(): void
    {
        $error = error_get_last();

        if ($error === null) {
            return;
        }

        // Only log fatal errors here
        $fatalTypes = [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR];

        if (!in_array($error['type'], $fatalTypes, true)) {
            return;
        }

        $message = "[" . date('Y-m-d H:i:s') . "] "
            . self::friendlyErrorType($error['type']) . ": "
            . $error['message']
            . " | File: " . $error['file']
            . " | Line: " . $error['line']
            . PHP_EOL . PHP_EOL;

        self::writeLog($message);

        // If possible, respond with 500
        if (!headers_sent()) {
            http_response_code(500);
        }

        echo "An unexpected error occurred.";
    }

    /**
     * Logs any Throwable with stack trace.
     */
    private static function logThrowable(Throwable $e): void
    {
        $message = "[" . date('Y-m-d H:i:s') . "] "
            . get_class($e) . ": " . $e->getMessage()
            . " | File: " . $e->getFile()
            . " | Line: " . $e->getLine()
            . PHP_EOL
            . $e->getTraceAsString()
            . PHP_EOL . PHP_EOL;

        self::writeLog($message);
    }

    /**
     * Writes to /logs/error.log in project root.
     */
    private static function writeLog(string $message): void
    {
        // app/core -> app -> project_root
        $rootDir = dirname(__DIR__, 2);
        $logDir  = $rootDir . DIRECTORY_SEPARATOR . "logs";

        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        file_put_contents($logDir . DIRECTORY_SEPARATOR . "error.log", $message, FILE_APPEND);
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
}
