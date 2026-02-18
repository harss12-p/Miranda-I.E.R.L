<?php

class Router
{
    private array $routes = [];

    public function get(string $path, string $handler, array $middlewares = [])
    {
        $this->routes['GET'][$path] = [$handler, $middlewares];
    }

    public function post(string $path, string $handler, array $middlewares = [])
    {
        $this->routes['POST'][$path] = [$handler, $middlewares];
    }

    public function dispatch(string $uri, string $method)
    {
        $uri = parse_url($uri, PHP_URL_PATH);

        $route = $this->routes[$method][$uri] ?? null;

        if (!$route) {
            http_response_code(404);
            echo "404 - Ruta no encontrada";
            return;
        }

        [$handler, $middlewares] = $route;

        // Ejecutar middlewares
        foreach ($middlewares as $middleware) {
            require_once __DIR__ . "/../app/middlewares/$middleware.php";
            $middleware::handle();
        }

        [$controller, $action] = explode('@', $handler);

        require_once __DIR__ . "/../app/controllers/$controller.php";

        $controllerInstance = new $controller();
        $controllerInstance->$action();
    }
}