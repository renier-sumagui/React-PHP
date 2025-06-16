<?php

declare(strict_types=1);

namespace App\Database;

use mysqli;
use mysqli_sql_exception;
use Exception;

class Connection
{
    private mysqli $connection;

    public function __construct()
    {
        $host = $_ENV['DB_HOST'] ?? 'localhost';
        $user = $_ENV['DB_USER'] ?? 'root';
        $pass = $_ENV['DB_PASS'] ?? 'root';
        $name = $_ENV['DB_NAME'] ?? 'the_blog_page';

        mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ERROR);

        try {
            $this->connection = new mysqli($host, $user, $pass, $name);
            $this->connection->set_charset('utf8mb4');
        } catch (mysqli_sql_exception $e) {
            throw new Exception('Failed to connect to database: ' . $e->getmessage());
        }
    }

    public function fetchAll(string $query): array | false
    {
        $result = $this->connection->query($query);

        if ($result === false) {
            return false;
        }

        $data = [];

        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $result->free();

        return $data;
    }

    public function fetchRecord(string $query, string $types, array $values): ?array
    {
        $stmt = $this->connection->prepare($query);

        if (!$stmt) {
            throw new Exception('Failed to prepare statement: ' . $this->connection->error);
        }

        $stmt->bind_param($types, ...$values);

        $stmt->execute();

        $result = $stmt->get_result();

        $data = $result->fetch_assoc();

        $stmt->close();

        return $data ?: null;
    }

    public function runQuery(string $query, string $types, array $values): int
    {
        $stmt = $this->connection->prepare($query);

        if (!$stmt) {
            throw new Exception('Failed to prepare statement: ' . $this->connection->error);
        }

        $stmt->bind_param($types, ...$values);

        $success = $stmt->execute();

        if (!$success) {
            $error = $stmt->error;
            $stmt->close();
            throw new Exception('Query execution failed: ' . $error);
        }

        $insertId = $this->connection->insert_id;

        $stmt->close();

        return $insertId > 0 ? $insertId : 0;
    }

    public function escapeString(string $string): string
    {
        return $this->connection->real_escape_string($string);
    }

    public function getConnection(): mysqli
    {
        return $this->connection;
    }
}
