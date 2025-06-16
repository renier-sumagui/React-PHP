<?php

declare(strict_types=1);

namespace App\Core;

class Request
{
    private string $method;
    private string $path;
    private array $headers;
    private array $queryParams;
    private array $body;

    public function __construct()
    {
        $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $this->headers = $this->parseHeaders();
        $this->queryParams = $_GET;
        $this->body = $this->parseBody();
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getHeaders(): array
    {
        return $this->headers;
    }

    public function getHeader(string $name): ?string
    {
        return $this->headers[$name] ?? null;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function getBody(): array
    {
        return $this->body;
    }

    private function parseHeaders(): array
    {
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $name = str_replace('_', '-', strtolower(substr($key, 5)));
                $headers[$name] = $value;
            }
        }

        return $headers;
    }

    private function parseBody(): array
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';

        if (stripos($contentType, 'application/json') !== false) {
            $input = file_get_contents('php://input');

            return json_decode($input, true) ?? [];
        }

        if ($_POST) {
            return $_POST;
        }

        return [];
    }
}
