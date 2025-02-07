<?php

namespace App\Auth\Domain\Entity;

use App\Auth\Domain\Entity\Token;

class User
{
    public readonly int $id;
    public readonly string $email;
    public readonly string $passwordHash;
    protected ?Token $token;

    public function __construct(int $id, string $email, string $passwordHash)
    {
        $this->id = $id;
        $this->email = $email;
        $this->passwordHash = $passwordHash;
    }

    public function getToken(): ?Token
    {
        return $this->token;
    }

    public function setToken(?Token $token): void
    {
        $this->token = $token;
    }
}
