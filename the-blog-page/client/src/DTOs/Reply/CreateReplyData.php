<?php

namespace App\DTOs\Reply;

class CreateReplyData
{
    public function __construct(
        public readonly int $userId,
        public readonly int $commentId,
        public readonly string $content,
    ) {}
}