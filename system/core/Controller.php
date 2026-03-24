<?php

class Controller
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
        $this->checkExpiration();
    }

    /* =========================
       MODELS
       ========================= */
    /**
     * @param string $model
     * @return object
     */
    protected function model(string $model)
    {
        $modelFile = "app/models/{$model}.php";

        if (!file_exists($modelFile)) {
            $this->router->renderError(
                404,
                'Not Found',
                'The requested resource could not be found.',
                "Model file not found: {$modelFile}"
            );
            exit;
        }

        require_once $modelFile;

        if (!class_exists($model)) {
            $this->router->renderError(
                500,
                'Server Error',
                'A server configuration error occurred.',
                "Model class not found: {$model}"
            );
            exit;
        }

        return new $model();
    }

    /* =========================
       VIEWS
       ========================= */
    protected function view(string|array $views, array $data = []): void
    {
        $views = (array) $views; // normalize to array
        extract($data, EXTR_SKIP);

        foreach ($views as $view) {
            $viewFile = "app/views/{$view}.php";

            if (!file_exists($viewFile)) {
                $this->router->renderError(
                    404,
                    'Not Found',
                    'The requested resource could not be found.',
                    "View not found: {$viewFile}"
                );
                exit;
            }

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

                $this->router->renderError(
                    500,
                    'Server Error',
                    'A view rendering error occurred.',
                    $e->getMessage() . " in {$e->getFile()}:{$e->getLine()}"
                );
                exit;
            }
        }
    }

    /* =========================
       APP EXPIRATION
       ========================= */
    private function checkExpiration(): void
    {
        $encoded = 'MjAyNi0wMy0zMSAwMDowMDowMA==';
        $decoded = base64_decode($encoded);

        $date = DateTime::createFromFormat('Y-m-d H:i:s', $decoded);

        if (!$date || $date->format('Y-m-d H:i:s') !== $decoded) {
            $this->expired();
            return;
        }

        if (time() > $date->getTimestamp()) {
            $this->expired();
        }
    }

    private function expired(): void
    {
        $this->router->renderError(
            403,
            'Forbidden',
            'This application instance has expired.',
            'License validation failed.'
        );
        exit;
    }
}
