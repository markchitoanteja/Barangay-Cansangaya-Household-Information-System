<?php

final class DatabaseConnectionException extends RuntimeException
{
    public int $httpCode;
    public string $title;
    public string $publicMessage;
    public ?string $details;

    public function __construct(
        int $code,
        string $title,
        string $message,
        ?string $details = null
    ) {
        parent::__construct($message);

        $this->httpCode = $code;
        $this->title = $title;
        $this->publicMessage = $message;
        $this->details = $details;
    }

    public function render(): void
    {
        // Clear any output already produced
        while (ob_get_level() > 0) {
            ob_end_clean();
        }

        http_response_code($this->httpCode);

        $code    = $this->httpCode;
        $title   = $this->title;
        $message = $this->publicMessage;
        $details = $this->details;

        $viewFile = "app/views/errors/{$code}.php";

        $base = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/'), '/\\');
        $homeUrl = ($base === '' || $base === '/') ? '/' : $base . '/';

        // Fallback if template missing
        if (!file_exists($viewFile)) {
            echo "{$code} {$title} - {$message}";
            if ($details) {
                echo "<pre>" . htmlspecialchars($details, ENT_QUOTES, 'UTF-8') . "</pre>";
            }
            exit;
        }

        // Expose variables to view
        $vars = compact('code', 'title', 'message', 'details', 'homeUrl');
        extract($vars, EXTR_SKIP);

        ob_start();

        $prevHandler = set_error_handler(function ($severity, $msg, $file, $line) {
            if (!(error_reporting() & $severity)) {
                return false;
            }
            throw new ErrorException($msg, 0, $severity, $file, $line);
        });

        try {

            require $viewFile;

            restore_error_handler();
            ob_end_flush();
        } catch (Throwable $e) {

            restore_error_handler();
            ob_end_clean();

            echo "{$code} {$title} - {$message}";
            echo "<pre>" . htmlspecialchars(
                ($details ? $details . "\n\n" : '') .
                    $e->getMessage() . " in {$e->getFile()}:{$e->getLine()}",
                ENT_QUOTES,
                'UTF-8'
            ) . "</pre>";
        }

        exit;
    }
}
