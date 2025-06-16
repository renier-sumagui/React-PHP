<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Connection;
use App\Contracts\ReplyInterface;
use App\DTOs\Reply\CreateReplyData;
use ErrorException;

class Reply implements ReplyInterface
{
    private Connection $db;
    
    public function __construct() {
        $this->db = new Connection();
    }

    public function create(CreateReplyData $data): int
    {
        $query = "
            INSERT INTO replies (user_id, comment_id, content, created_at, updated_at)
                VALUES (?, ?, ?, NOW(), NOW());
        ";
        $values = [$data->userId, $data->commentId, $data->content];
        $types = 'iis';

        $result = $this->db->runQuery($query, $types, $values);

        return $result;
    }

    public function getReplyById(int $id): array
    {
        $query = "
            SELECT 
                r.id AS reply_id,
                r.content AS content,
                u.id AS user_id,
                u.first_name,
                u.last_name,
                r.created_at,
                r.updated_at
            FROM replies r
            INNER JOIN users u ON u.id = r.user_id
            WHERE r.id = ?;
        ";
        $types = "i";
        $values = [$id];

        $result = $this->db->fetchRecord($query, $types, $values);

        return $result;
    }
}