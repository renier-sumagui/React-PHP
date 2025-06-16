<?php

namespace App\DTOs\User;

class CreateUserData
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $password,
        public readonly string $confirmPassword
    ) {}
}