<?php

namespace App\Auth\Repository;

use App\Shared\Infrastructure\Repository\Repository;

class UserRepository extends Repository
{
    protected string $table = 'users';

    public function getUserByEmail(string $email): array|false
    {
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->table)
            ->where('email = :email')
            ->setParameter('email', $email)
            ->fetchAssociative();
    }

    public function getByActivationCode(string $activationCode): array
    {
        return $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->table)
            ->where('activation_code = :activation_code')
            ->setParameter('activation_code', $activationCode)
            ->fetchAllAssociative();
    }

    public function createUser(string $email, string $passwordHash): int
    {
        $this->connection->createQueryBuilder()
            ->insert($this->table)
            ->values([
                'email' => $email,
                'password' => $passwordHash,
            ])
            ->executeQuery()
            ->rowCount();

        return $this->connection->lastInsertId();
    }
}
