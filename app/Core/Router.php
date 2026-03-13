<?php

namespace App\Core;

use App\http\Request;

class Router
{
    private $routes = [];

    public function get($url, $action)
    {
        $this->routes['GET'][$url] = $action;
    }

    public function post($url,$action){
        $this->routes['POST'][$url] = $action;
    }
    public function dispatch($url)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $routes = $this->routes[$method] ?? [];
        $request = new Request();
        foreach ($routes as $route => $action) {
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $route);
            $pattern = "@^" . $pattern . "$@";

            if (preg_match($pattern, $url, $matches)) {
                $params = array_filter(
                    $matches,
                    fn($key) => !is_int($key),
                    ARRAY_FILTER_USE_KEY
                );

                if ($action instanceof \Closure) {
                    $action($request, $params);
                    return;
                }

                if (is_array($action)) {
                    $controller = $action[0];
                    $method = $action[1];
                    if (!class_exists($controller)) {
                        echo "Controller not found";
                        return;
                    }
                    $controller = new $controller($request);
                    if (!method_exists($controller, $method)) {
                        echo "Method not found";
                        return;
                    }
                    $controller->$method($request, $params);
                    return;
                }

                echo "Invalid route action";
                return;
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}
