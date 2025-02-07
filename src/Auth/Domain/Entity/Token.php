<?php

namespace App\Auth\Domain\Entity;

use App\Shared\Domain\Entity\Entity;

class Token extends Entity
{
    public readonly int $userId;

    public readonly string $authToken;

    public readonly string $refreshToken;

    protected array $payload;

    public function __construct(int $userId, string $authToken, string $refreshToken)
    {
        $this->userId = $userId;
        $this->authToken = $authToken;
        $this->refreshToken = $refreshToken;
    }

    public function jsonSerialize(): mixed
    {
        return [
            'user_id' => $this->userId,
            'auth_token' => $this->authToken,
            'refresh_token' => $this->refreshToken,
        ];
    }
}
