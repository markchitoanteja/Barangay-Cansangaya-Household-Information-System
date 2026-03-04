<?php

class Router
{
    private array $routes = []; // [METHOD][] = ['pattern'=>..., 'regex'=>..., 'handler'=>..., 'paramNames'=>...]

    public function __construct()
    {
        $this->loadRoutes();
    }

    public function get(string $path, string $handler): void
    {
        $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, string $handler): void
    {
        $this->addRoute('POST', $path, $handler);
    }

    public function put(string $path, string $handler): void
    {
        $this->addRoute('PUT', $path, $handler);
    }

    public function delete(string $path, string $handler): void
    {
        $this->addRoute('DELETE', $path, $handler);
    }

    private function loadRoutes(): void
    {
        $routesFile = 'app/routes/routes.php';
        if (!file_exists($routesFile)) {
            return;
        }

        $register = require $routesFile;
        if (is_callable($register)) {
            $register($this);
        }
    }

    private function addRoute(string $method, string $path, string $handler): void
    {
        $path = '/' . trim($path, '/');

        [$controller, $action] = $this->parseHandler($handler);

        // Convert /users/{id} to regex, capture param names
        $paramNames = [];
        $regex = preg_replace_callback('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', function ($m) use (&$paramNames) {
            $paramNames[] = $m[1];
            return '([^\/]+)';
        }, $path);

        $regex = '#^' . $regex . '$#';

        $this->routes[$method][] = [
            'pattern'    => $path,
            'regex'      => $regex,
            'handler'    => [$controller, $action],
            'paramNames' => $paramNames,
        ];
    }

    private function parseHandler(string $handler): array
    {
        // Accept "Controller@method"
        if (!str_contains($handler, '@')) {
            throw new InvalidArgumentException("Invalid handler format: {$handler}. Use Controller@method");
        }
        [$controller, $method] = explode('@', $handler, 2);
        return [$controller, $method];
    }

    public function dispatch(string $url): void
    {
        $path = '/' . trim(parse_url($url, PHP_URL_PATH) ?? '', '/');
        if ($path === '//') $path = '/';

        $httpMethod = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

        // 1) Try explicit route match first
        if ($this->dispatchDefinedRoute($httpMethod, $path)) {
            return;
        }

        // 2) Fallback to your convention-based routing
        $url = trim($url, '/');
        $segments = $url === '' ? [] : explode('/', $url);

        $controllerSegment = $segments[0] ?? 'home';
        $method            = $segments[1] ?? 'index';
        $params            = array_slice($segments, 2);

        if (!preg_match('/^[a-zA-Z0-9_]+$/', $method)) {
            $this->renderError(400, 'Bad Request', 'Invalid method name.');
            return;
        }

        $controllerName = $this->controllerClass($controllerSegment);
        $controllerFile = "app/controllers/{$controllerName}.php";

        if (!file_exists($controllerFile)) {
            $this->renderError(404, 'Not Found', 'The page you requested could not be found.', "Missing controller file: {$controllerFile}");
            return;
        }

        require_once $controllerFile;

        if (!class_exists($controllerName)) {
            $this->renderError(500, 'Server Error', 'A server configuration error occurred.', "Missing controller class: {$controllerName}");
            return;
        }

        // ✅ FIX: pass Router instance into Controller constructor
        $controller = new $controllerName($this);

        if (!method_exists($controller, $method)) {
            $this->renderError(404, 'Not Found', 'The page you requested could not be found.', "Missing method: {$controllerName}::{$method}");
            return;
        }

        try {
            call_user_func_array([$controller, $method], $params);
        } catch (Throwable $e) {
            $this->renderError(500, 'Server Error', 'Something went wrong while processing your request.', $e->getMessage());
        }
    }

    private function dispatchDefinedRoute(string $httpMethod, string $path): bool
    {
        $candidates = $this->routes[$httpMethod] ?? [];

        foreach ($candidates as $route) {
            if (!preg_match($route['regex'], $path, $matches)) {
                continue;
            }

            array_shift($matches); // full match out
            $params = $matches;

            [$controllerName, $method] = $route['handler'];

            // basic method sanitize
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $method)) {
                $this->renderError(400, 'Bad Request', 'Invalid method name.');
                return true;
            }

            $controllerFile = "app/controllers/{$controllerName}.php";
            if (!file_exists($controllerFile)) {
                $this->renderError(500, 'Server Error', 'Route points to missing controller file.', "Missing controller file: {$controllerFile}");
                return true;
            }

            require_once $controllerFile;

            if (!class_exists($controllerName)) {
                $this->renderError(500, 'Server Error', 'Route points to missing controller class.', "Missing controller class: {$controllerName}");
                return true;
            }

            // ✅ FIX: pass Router instance into Controller constructor
            $controller = new $controllerName($this);

            if (!method_exists($controller, $method)) {
                $this->renderError(500, 'Server Error', 'Route points to missing controller method.', "Missing method: {$controllerName}::{$method}");
                return true;
            }

            try {
                call_user_func_array([$controller, $method], $params);
            } catch (Throwable $e) {
                $this->renderError(500, 'Server Error', 'Something went wrong while processing your request.', $e->getMessage());
            }

            return true;
        }

        return false;
    }

    public function renderError(int $code, string $title, string $message, ?string $details = null): void
    {
        http_response_code($code);

        $viewFile = "app/views/errors/{$code}.php";

        $base = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '/'), '/\\');
        $homeUrl = ($base === '' || $base === '/') ? '/' : $base . '/';

        if (!file_exists($viewFile)) {
            echo "{$code} {$title} - {$message}";
            if ($details) echo "<pre>" . htmlspecialchars($details) . "</pre>";
            return;
        }

        $code = $code;
        $title = $title;
        $message = $message;
        $details = $details;
        $homeUrl = $homeUrl;

        require $viewFile;
    }

    private function controllerClass(string $segment): string
    {
        $segment = trim($segment);

        if (!preg_match('/^[a-zA-Z0-9_-]+$/', $segment)) {
            return 'HomeController';
        }

        $segment = str_replace(['-', '_'], ' ', strtolower($segment));
        $segment = str_replace(' ', '', ucwords($segment));

        return $segment . 'Controller';
    }
}
