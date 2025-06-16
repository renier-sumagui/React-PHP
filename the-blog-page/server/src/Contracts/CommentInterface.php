<?php
declare(strict_types=1);

namespace App\Contracts;

use App\DTOs\Comment\CreateCommentData;
use ErrorException;

interface CommentInterface
{
    /**
     * @throws \ErrorException
     */
    public function create(CreateCommentData $data): int;

    /**
     * @throws \ErrorException
     */
    public function getAllWithReplies(): ?array;

    /**
     * @throws \ErrorException
     */
    public function getCommentById(int $id): ?array;
}