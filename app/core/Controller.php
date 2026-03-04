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
            return null;
        }

        require_once $modelFile;

        if (!class_exists($model)) {
            $this->router->renderError(
                500,
                'Server Error',
                'A server configuration error occurred.',
                "Model class not found: {$model}"
            );
            return null;
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
            $this->router->renderError(
                404,
                'Not Found',
                'The requested resource could not be found.',
                "View not found: {$viewFile}"
            );
            return;
        }

        extract($data, EXTR_SKIP);
        require $viewFile;
    }
}
