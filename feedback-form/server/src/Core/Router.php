<?php

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, callable $handler)
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable $handler)
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(Request $request): Response
    {
        $method = $request->getMethod();
        $path = $request->getPath();

        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];
            $result = call_user_func($handler, $request);

            return new Response($result);
        }

        return new Response(["error" => "Not Found"], 404);
    }
}
