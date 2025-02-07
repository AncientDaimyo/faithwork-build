<?php

namespace App\Auth\Application\Boundary;

interface AuthServiceBoundary
{
    public function register(array $data): void;
    public function login(array $data): void;
    public function refresh(string $refreshToken): void;
    public function logout(array $data): void;
}
