<?php

class Router {
    private $routes = [
        'GET'  => [],
        'POST' => []
    ];

    public function get(string $path, string $callback): void {
        $this->routes['GET'][$path] = $callback;
    }

    public function post(string $path, string $callback): void {
        $this->routes['POST'][$path] = $callback;
    }

    public function dispatch(): void {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $uri    = rtrim($uri, '/') ?: '/';

        // Xử lý cả trường hợp có /public/index.php trong URL
        $scriptName = $_SERVER['SCRIPT_NAME'];
        $uri        = str_replace($scriptName, '', $uri);
        $uri        = rtrim($uri, '/') ?: '/';

        if (isset($this->routes[$method][$uri])) {
            $callback = $this->routes[$method][$uri];
            [$controllerName, $action] = explode('@', $callback);

            $controllerFile = __DIR__ . '/../app/Controllers/' . $controllerName . '.php';

            if (file_exists($controllerFile)) {
                require_once $controllerFile;
                $controller = new $controllerName();
                $controller->$action();
                return;
            }
        }

        http_response_code(404);
        echo "404 - Route không tồn tại!";
    }
}
