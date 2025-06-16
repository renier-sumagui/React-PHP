<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Connection;
use ErrorException;

class Feedback
{
    private Connection $db;

    public function __construct()
    {
        $this->db = new Connection();
    }

    public function add($data): int | ErrorException
    {
            $query = "
        INSERT INTO feedbacks
            (name, course_id, score, reason, created_at, updated_at)
        VALUES
            (?, ?, ?, ?, NOW(), NOW());
        ";

        $values = [ucfirst($data["name"]), $data["track"], $data["score"], $data["reason"]];
        $types = "ssis";

        try {
            $result = $this->db->runQuery($query, $types, $values);

            return $result;
        } catch (ErrorException $err) {
            return $err;
        }
    }

    public function all(): array
    {
        return $this->db->fetchAll("SELECT * FROM feedbacks");
    }
}