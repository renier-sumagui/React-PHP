<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Connection;
use App\Contracts\CommentInterface;
use App\DTOs\Comment\CreateCommentData;

class Comment implements CommentInterface
{
    private Connection $db;

    public function __construct()
    {
        $this->db = new Connection();
    }

    public function create(CreateCommentData $data): int
    {
        $query = "
            INSERT INTO comments (user_id, content, created_at, updated_at)
                VALUES (?, ?, NOW(), NOW());
        ";
        $types = "is";
        $values = [$data->userId, $data->content];

        $result = $this->db->runQuery($query, $types, $values);

        return $result;
    }

    public function getCommentById(int $id): ?array
    {
        $query = "
            SELECT 
                c.id AS comment_id,
                c.content AS content,
                u.id AS user_id,
                u.first_name,
                u.last_name,
                c.created_at,
                c.updated_at
            FROM comments c
            INNER JOIN users u ON u.id = c.user_id
            WHERE c.id = ?;
        ";
        $types = "i";
        $values = [$id];

        $result = $this->db->fetchRecord($query, $types, $values);

        return $result;
    }

    public function getAllWithReplies(): array
    {
        $query = "
            SELECT 
                c.id AS comment_id,
                c.content AS comment_content,
                c.created_at AS comment_created,
                c.updated_at AS comment_updated,
                cu.id AS comment_user_id,
                cu.first_name AS comment_user_first_name,
                cu.last_name AS comment_user_last_name,

                r.id AS reply_id,
                r.content AS reply_content,
                r.created_at AS reply_created,
                r.updated_at AS reply_updated,
                ru.id AS reply_user_id,
                ru.first_name AS reply_user_first_name,
                ru.last_name AS reply_user_last_name

            FROM comments c
            JOIN users cu ON c.user_id = cu.id
            LEFT JOIN replies r ON r.comment_id = c.id
            LEFT JOIN users ru ON r.user_id = ru.id
            ORDER BY c.id, r.id;
        ";

        $comments = $this->db->fetchAll($query);
        $groupedComments = [];

        if (count($comments) > 0) {
            foreach ($comments as $comment) {
                if (!isset($groupedComments[$comment['comment_id']])) {
                    $groupedComments[$comment['comment_id']] = [
                        'id' => (int) $comment['comment_id'],
                        'content' => $comment['comment_content'],
                        'createdAt' => $comment['comment_created'],
                        'updatedAt' => $comment['comment_updated'],
                        'user' => [
                            'firstName' => $comment['comment_user_first_name'],
                            'lastName' => $comment['comment_user_last_name']
                        ],
                        'replies' => []
                    ];
                }

                if (!empty($comment['reply_id'])) {
                    array_push($groupedComments[$comment['comment_id']]['replies'], [
                        'id' => (int) $comment['reply_id'],
                        'content' => $comment['reply_content'],
                        'createdAt' => $comment['reply_created'],
                        'updatedAt' => $comment['reply_updated'],
                        'user' => [
                            'firstName' => $comment['reply_user_first_name'],
                            'lastName' => $comment['reply_user_last_name']
                        ]
                    ]);
                }
            }
        }

        return array_values($groupedComments);
    }
}