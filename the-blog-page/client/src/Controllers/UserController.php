<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\DTOs\User\CreateUserData;
use App\Core\Request;
use ErrorException;
use App\Utils\Jwt;

class UserController
{
    private User $user;

    public function __construct()
    {
         $this->user = new User();
    }

    public function signUp(Request $request): array
    {
        $body = $request->getBody();

        $firstName = $body['firstName'];
        $lastName = $body['lastName'];
        $email = $body['email'];
        $password = $body['password'];
        $confirmPassword = $body['confirmPassword'];

        $userData = new CreateUserData($firstName, $lastName, $email, $password, $confirmPassword);

        try {
            $result = $this->user->create($userData);

            if ($result['success'] === 0) {
                return [
                    'status' => 400,
                    'body' => [...$result]
                ];
            }

            $user = $this->user->getUserById($result['id']);

            $jwt = new Jwt($_ENV['SECRET_KEY']);
            $payload = ['userId' => $user['id'], 'isLoggedIn' => 1];
            $token = $jwt->encode($payload);

            setcookie(
                'auth_token',
                $token,
                [
                    'expires' => time() + 3600,
                    'path' => '/',
                    'secure' => false,
                    'httponly' => true,
                ]
            );

            return [
                'success' => 1,
                'user' => [
                    'firstName' => $user['first_name'],
                    'lastName' => $user['last_name'],
                    'email' => $user['email']
                ]
            ];
        } catch (ErrorException $err) {
            return ['success' => 0, 'message' => 'Failed to create user'];
        }
    }

    public function signIn(Request $request): array
    {
        $body = $request->getBody();
        $email = $body['email'];
        $password = $body['password'];
        
        $user = $this->user->getUserByEmail($email);

        if ($user) {
            $salt = $user['salt'];
            $userPass = $user['password'] . $salt;

            $encryptedPassword = md5($password) . $salt;

            if ($encryptedPassword === $userPass) {
                $jwt = new Jwt($_ENV['SECRET_KEY']);

                $payload = ['userId' => $user['id'], 'isLoggedIn' => 1];
                $token = $jwt->encode($payload);

                setcookie(
                    'auth_token',
                    $token,
                    [
                        'expires' => time() + 3600,
                        'path' => '/',
                        'secure' => false,
                        'httponly' => true,
                    ]
                );

                return [
                    'success' => 1,
                    'user' => [
                        'id' => $user['id'],
                        'firstName' => $user['first_name'],
                        'lastName' => $user['last_name'],
                        'email' => $user['email'],
                    ]
                ];
            }
        } 

        return [
            'success' => 0,
            'message' => 'Email or password is incorrect'
        ];
    }

    public function signOut(Request $request): array
    {
        if (isset($_COOKIE['auth_token'])) {
            unset($_COOKIE['auth_token']);
            setcookie('auth_token', '', -1, '/');
        }

        return [
            'success' => 1,
            'message' => 'Successfully logged out'
        ];
    }

    public function isLoggedIn(Request $request): array
    {
        if (isset($_COOKIE['auth_token'])) {
            $jwt = new Jwt($_ENV['SECRET_KEY']);
            $token = $_COOKIE['auth_token'];
            $isValid = $jwt->verify($token);

            if ($isValid) {
                $tokenPayload = $jwt->decode($token);

                try {
                    $user = $this->user->getUserById($tokenPayload['userId']);

                    return [
                            'user' => [
                                'id' => $user['id'],
                                'firstName' => $user['first_name'],
                                'lastName' => $user['last_name'],
                                'email' => $user['email'],
                                'createdAt' => $user['created_at']
                        ],
                        'isLoggedIn' => 1,
                        'success' => 1
                    ];
                } catch (ErrorException $err) {
                    return [
                        'body' => [
                            'success' => 0,
                            'message' => 'Internal server error'
                        ],
                        'code' => 500
                    ];
                }
            }
        }

        return [
            'isLoggedIn' => 0
        ];
    }
}