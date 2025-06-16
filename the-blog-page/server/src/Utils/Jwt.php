<?php

declare(strict_types=1);

namespace App\Utils;

use App\Exceptions\InvalidSignatureException;
use InvalidArgumentException;

class Jwt
{
    public function __construct(private string $key)
    {

    }

    public function encode(array $payload): string
    {
        $header = json_encode([
            'alg' => 'HS256',
            'typ' => 'JWT'
        ]);

        $header = $this->base64UrlEncode($header);
        $payload = json_encode($payload);
        $payload = $this->base64UrlEncode($payload);

        $signature = hash_hmac('sha256', $header . '.' . $payload, $this->key, true);
        $signature = $this->base64UrlEncode($signature);

        return $header . '.' . $payload . '.' . $signature;
    }

    public function decode(string $token): array
    {
        if (
            preg_match(
                '/^(?<header>.+)\.(?<payload>.+)\.(?<signature>.+)$/',
                $token,
                $matches
            ) !== 1
        ) {
            throw new InvalidArgumentException('Invalid token format');
        }

        $signature = hash_hmac(
            'sha256',
            $matches['header'] . '.' . $matches['payload'],
            $this->key,
            true
        );

        $signatureFromToken = $this->base64UrlDecode($matches['signature']);

        if (!hash_equals($signature, $signatureFromToken)) {
            throw new InvalidSignatureException();
        }

        $payload = json_decode($this->base64UrlDecode($matches['payload']), true);

        return $payload;
    }

    public function verify(string $token): bool
    {
        if (
            preg_match(
                '/^(?<header>.+)\.(?<payload>.+)\.(?<signature>.+)$/',
                $token,
                $matches
            ) !== 1
        ) {
            return false;
        }

        $expectedSig = hash_hmac(
            'sha256',
            $matches['header'] . '.' . $matches['payload'],
            $this->key,
            true
        );

        $actualSig = $this->base64UrlDecode($matches['signature']);

        return hash_equals($expectedSig, $actualSig);
    }

    private function base64UrlEncode(string $text): string
    {
        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($text));
    }

    private function base64UrlDecode(string $text): string
    {
        return base64_decode(
            str_replace(
                ['-', '_'],
                ['+', '/'],
                $text
            )
        );
    }
}