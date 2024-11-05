<?php
namespace Router;

class Router {
    private $routes = [];

    // Adiciona a rota com suporte ao método HTTP
    public function addRoute($uriPattern, $controller, $method, $httpMethod = 'GET') {
        $uriPattern = preg_replace('/:\w+/', '(\w+)', $uriPattern);
        $this->routes[$httpMethod][$uriPattern] = [$controller, $method];
    }

    public function run() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $requestMethod = $_SERVER['REQUEST_METHOD'];

        if (!isset($this->routes[$requestMethod])) {
            http_response_code(405); // Método não permitido
            echo "405 Method Not Allowed";
            return;
        }

        foreach ($this->routes[$requestMethod] as $uriPattern => [$controller, $method]) {
            if (preg_match("#^$uriPattern$#", $uri, $matches)) {
                array_shift($matches); // Remove a URL completa da correspondência
                return (new $controller())->$method(...$matches);
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}
