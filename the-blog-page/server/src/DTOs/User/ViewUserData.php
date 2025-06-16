<?php

namespace App\DTOs\User;

class ViewUserData
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $password,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {}
}