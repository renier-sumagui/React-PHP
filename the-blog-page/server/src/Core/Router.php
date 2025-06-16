<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    public array $routes = [];

    public function get(string $path, callable $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function put(string $path, callable $handler): void
    {
        $this->routes['PUT'][$path] = $handler;
    }

    public function delete(string $path, callable $handler): void
    {
        $this->routes['DELETE'][$path] = $handler;
    }

    public function dispatch(Request $request): Response
    {
        $method = $request->getMethod();
        $path = $request->getPath();

        if (isset($this->routes[$method][$path])) {
            $handler = $this->routes[$method][$path];
            $result = call_user_func($handler, $request);

            if (is_array($result) && isset($result['status'], $result['body'])) {
                return new Response($result['body'], $result['status']);
            }

            return new Response($result);
        }

        return new Response(['error' => 'Not Found'], 404);
    }
}