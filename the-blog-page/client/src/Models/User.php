<?php

declare(strict_types=1);

namespace App\Models;

use App\DTOs\User\CreateUserData;
use App\Database\Connection;
use App\DTOs\User\ViewUserData;

class User
{
    private Connection $db;

    public function __construct()
    {
        $this->db = new Connection();
    }

    public function create(CreateUserData $data): array
    {
        $firstName = $data->firstName;
        $lastName = $data->lastName;
        $email = $data->email;
        $password = $data->password;
        $confirmPassword = $data->confirmPassword;

        $emailExists = $this->db->fetchRecord(
            'SELECT email FROM users WHERE email = ?', 
            's', 
            [$email]
        );

        if ($emailExists) {
            return [
                'errors' => [
                    'email' => 'Email already exists'
                ],
                'success' => 0
            ];
        }

        if ($password !== $confirmPassword) {
            return [
                'errors' => [
                    'password' => 'Passwords must be the same.'
                ],
                'success' => 0
            ];
        }

        $encryptedPassword = md5($password);
        $salt = bin2hex(openssl_random_pseudo_bytes(10));

        $query = '
            INSERT INTO users
                (first_name, last_name, email, password, salt, created_at, updated_at)
            VALUES 
                (?, ?, ?, ?, ?, NOW(), NOW());
        ';
        $types = "sssss";
        $values = [$firstName, $lastName, $email, $encryptedPassword, $salt];

        $result = $this->db->runQuery($query, $types, $values);

        return [
            'success' => 1,
            'id' => $result
        ];
    }

    public function getUserById(int $id): ?array
    {
        $query = '
            SELECT id, first_name, last_name, email, password, salt, created_at, updated_at 
            FROM users
            WHERE id = ?
        ';
        $types = 'i';
        $values = [$id];

        $user = $this->db->fetchRecord($query, $types, $values);

        return $user;
    }

    public function getUserByEmail(string $email): ?array
    {
        $query = '
            SELECT id, first_name, last_name, email, password, salt, created_at, updated_at FROM users
            WHERE email = ?
        ';
        $types = 's';
        $values = [$email];

        $result = $this->db->fetchRecord($query, $types, $values);

        return $result;
    }
}