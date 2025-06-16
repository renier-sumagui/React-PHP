<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTOs\Reply\CreateReplyData;
use ErrorException;

interface ReplyInterface
{
    /**
     * @throws \ErrorException
     */
    public function create(CreateReplyData $data): int;
}