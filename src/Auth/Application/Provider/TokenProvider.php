<?php

namespace App\Auth\Application\Provider;

use App\Auth\Domain\Entity\Token;
use App\Auth\Infrastructure\Repository\UserTokenRepository;
use Firebase\JWT\JWT;
use Psr\Container\ContainerInterface;
use Exception;
use Firebase\JWT\Key;

class TokenProvider
{
    private $secretKey;

    private const HS256 = 'HS256';

    protected UserTokenRepository $userTokenRepository;

    public function __construct(ContainerInterface $container, UserTokenRepository $userTokenRepository)
    {
        $this->secretKey = $container->get('secretKey');
        $this->userTokenRepository = $userTokenRepository;
    }

    public function createToken(int $userId, array $payload): Token
    {
        $token = new Token(
            $userId,
            $this->createAuthToken($userId, $payload),
            $this->createRefreshToken($userId, $payload)
        );

        $this->userTokenRepository->saveToken($userId, $token->authToken, $token->refreshToken);

        $tokenData = $token->jsonSerialize();

        $token = new Token(
            (int)$tokenData['user_id'],
            (string)$tokenData['auth_token'],
            (string)$tokenData['refresh_token']
        );

        return $token;
    }

    protected function createAuthToken(int $userId, array $payload): string
    {
        if (empty($payload['email'])) {
            throw new \InvalidArgumentException('Email не может быть пустым');
        }

        $token = [
            'userId' => $userId,
            'exp' => time() + 60 * 60, // Срок действия токена в секундах (1 час)
            'payload' => $payload
        ];

        try {
            $jwt = JWT::encode($token, $this->secretKey, self::HS256);
            return $jwt;
        } catch (Exception $e) {
            throw new \RuntimeException('Ошибка при создании JWT токена: ' . $e->getMessage());
        }
    }

    protected function createRefreshToken(int $userId, array $payload): string
    {
        if (empty($payload['email'])) {
            throw new \InvalidArgumentException('Email не может быть пустым');
        }

        $token = [
            'userId' => $userId,
            'exp' => time() + 60 * 60 * 24 * 7, // Срок действия refresh токена в секундах (1 неделя)
            'payload' => $payload
        ];

        try {
            $jwt = JWT::encode($token, $this->secretKey, self::HS256);
            return $jwt;
        } catch (Exception $e) {
            throw new \RuntimeException('Ошибка при создании refresh токена: ' . $e->getMessage());
        }
    }

    public function decodeAuthToken(string $token): ?object
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, self::HS256));
            return $decoded;
        } catch (Exception $e) {
            return null;
        }
    }

    public function decodeRefreshToken(string $token): ?object
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secretKey, self::HS256));
            return $decoded;
        } catch (Exception $e) {
            throw new \RuntimeException('Ошибка при декодировании refresh токена: ' . $e->getMessage());
            return null;
        }
    }
}
