<?php

declare(strict_types=1);

namespace App\Models;

use App\Database\Connection;
use ErrorException;

class Course
{
    private Connection $db;

    public function __construct() {
        $this->db = new Connection;
    }

    public function getCourse(string | int $id): ?array
    {
        $query = "
            SELECT id, name, created_at, updated_at FROM courses
            WHERE id = ?;
        ";
        $types = "i";
        $values = [$id];

        $result = $this->db->fetchRecord($query, $types, $values);

        return $result;
    }

    public function getCoures(): ?array
    {
        $query = "SELECT id, name, created_at, updated_at FROM courses";

        $result = $this->db->fetchAll($query);

        return $result;
    }
}