<?php

namespace App\Auth\Repository;

use App\Auth\Entity\Token;
use App\Shared\Infrastructure\Repository\Repository;

class UserTokenRepository extends Repository
{
    protected string $table = 'user_tokens';

    public function getTokenByUserId($userId)
    {
        return $this->connection->fetchAssociative('SELECT * FROM ' . $this->table . ' WHERE user_id = :user_id', ['user_id' => $userId]);
    }

    public function deleteTokensByUserId($userId)
    {
        return $this->connection->executeStatement('DELETE FROM ' . $this->table . ' WHERE user_id = :user_id', ['user_id' => $userId]);
    }

    public function saveToken(int $userId, Token $token)
    {
        $sql = <<<SQL
INSERT INTO user_tokens (user_id, auth_token, refresh_token) VALUES (:user_id, :auth_token, :refresh_token)
ON DUPLICATE KEY UPDATE auth_token = :auth_token, refresh_token = :refresh_token
SQL;

        return $this->connection->executeStatement($sql, [
            'user_id' => $userId,
            'auth_token' => $token->authToken,
            'refresh_token' => $token->refreshToken,
        ]);
    }

    public function getUserIdByToken(string $token)
    {
        return $this->connection->createQueryBuilder()
            ->select('user_id')
            ->from($this->table)
            ->where('auth_token = :token')
            ->setParameter('token', $token)
            ->fetchOne();
    }

    public function getUserIdByRefreshToken(string $token)
    {
        return $this->connection->createQueryBuilder()
            ->select('user_id')
            ->from($this->table)
            ->where('refresh_token = :token')
            ->setParameter('token', $token)
            ->fetchOne();
    }
}
