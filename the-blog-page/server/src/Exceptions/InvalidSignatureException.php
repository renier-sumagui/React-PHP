<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class InvalidSignatureException extends Exception
{
    public function __construct(
        string $message = 'Invalid signature.',
        int $code = 0,
        ?Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}