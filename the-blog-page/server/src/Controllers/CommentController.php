<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Request;
use App\DTOs\Comment\CreateCommentData;
use App\Models\Comment;
use ErrorException;

class CommentController
{
    private Comment $comment;

    public function __construct()
    {
        $this->comment = new Comment();
    }

    public function createComment(Request $request): array
    {
        $body = $request->getBody();

        $userId = $body['userId'];
        $content = $body['content'];

        $comment = new CreateCommentData($userId, $content);

        $result = $this->comment->create($comment);

        if ($result) {
            $comment = $this->comment->getCommentById($result);

            return [
                'message' => 'Successfully created comment',
                'success' => 1,
                'data' => [
                    'id' => $comment['comment_id'],
                    'content' => $comment['content'],
                    'user' => [
                        'firstName' => $comment['first_name'],
                        'lastName' => $comment['last_name'],
                    ],
                    'createdAt' => $comment['created_at'],
                    'updatedAt' => $comment['updated_at']
                ]
            ];
        }

        return [
            'message' => 'Failed to create comment',
            'success' => 0
        ];
    }

    public function getAllWithReplies(Request $request): array
    {
        try {
            $comments = $this->comment->getAllWithReplies();

            return [
                'success' => 1,
                'message' => 'Successfully fetched comments',
                'data' => $comments
            ];
        } catch (ErrorException $err) {
            return [
                'message' => 'Failed to fetch comments',
                'success' => 0
            ];
        }
    }
}