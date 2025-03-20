<?php

namespace App\Auth\Interface;

use App\Auth\Entity\User;
use App\Auth\Entity\Token;
use Slim\Psr7\Request;

interface AuthServiceInterface
{
    public function login(string $email, string $password): ?Token;
    public function register(string $email, string $password): null|array;
    public function refresh(string $refreshToken): ?Token;
    public function logout(int $userId): void;
    public function activateRegistration(string $activationCode);
    public function auth(Request $request): ?User;
}
