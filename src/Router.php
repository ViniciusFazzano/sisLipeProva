<?php
class Router {
    private $routes = [];

    public function addRoute($uri, $controller, $method) {
        $this->routes[$uri] = [$controller, $method];
    }

    public function run() {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if (array_key_exists($uri, $this->routes)) {
            list($controller, $method) = $this->routes[$uri];
            echo "aqui";
            (new $controller())->$method();
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
    }
}
