<?php

namespace App\DTOs\Comment;

class CreateCommentData
{
    public function __construct(
        public readonly int $userId,
        public readonly string $content
    ) {}
}