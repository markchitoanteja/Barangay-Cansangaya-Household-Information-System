<?php

class Controller
{
    /* =========================
       MODELS
       ========================= */
    protected function model(string $model)
    {
        require_once "app/models/{$model}.php";
        return new $model();
    }

    /* =========================
       VIEWS
       ========================= */
    protected function view(string $view, array $data = []): void
    {
        $viewFile = "app/views/{$view}.php";

        if (!file_exists($viewFile)) {
            http_response_code(500);
            echo "View not found: {$viewFile}";
            return;
        }

        extract($data, EXTR_SKIP);
        require $viewFile;
    }
}
