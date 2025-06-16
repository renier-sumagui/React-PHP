<?php

declare(strict_types=1);

namespace App\Core;

class Response
{
    private mixed $data;
    private int $statusCode;
    private array $headers;

    public function __construct(mixed $data = [], int $statusCode = 200, array $headers = [])
    {
        $this->data = $data;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    public function send(): void
    {
        http_response_code($this->statusCode);

        header('Content-Type: application/json');
        foreach ($this->headers as $key => $value) {
            header("$key: $value");
        }

        echo json_encode($this->data);
    }

    public function setHeader(string $key, string $value): void
    {
        $this->headers[$key] = $value;
    }

    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    public function setData(mixed $data): void
    {
        $this->data = $data;
    }
}