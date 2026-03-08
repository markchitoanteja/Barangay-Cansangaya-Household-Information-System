<?php

class Controller
{
    protected Router $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
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
    protected function view(string $view, array $data = []): void
    {
        $viewFile = "app/views/{$view}.php";

        if (!file_exists($viewFile)) {
            $this->router->renderError(404, 'Not Found', 'The requested resource could not be found.', "View not found: {$viewFile}");
            exit;
        }

        extract($data, EXTR_SKIP);

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
