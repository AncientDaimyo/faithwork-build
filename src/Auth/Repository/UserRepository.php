<?php

namespace App\Auth\Repository;

use App\Shared\Infrastructure\Repository\Repository;
use App\Auth\Storage\RoleStorage;

class UserRepository extends Repository
{
    protected string $table = 'users';

    public function getUserByEmail(string $email, bool $checkActivation = false): array|false
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
        $query = <<<SQL
INSERT INTO {$this->table} (email, password, role, activated) VALUES (:email, :password, :role, :activated)
SQL;

        $this->connection->executeQuery($query, [
            'email' => $email,
            'password' => $passwordHash,
            'role' => RoleStorage::CUSTOMER,
            'activated' => 0,
        ]);

        return $this->connection->lastInsertId();
    }
}
