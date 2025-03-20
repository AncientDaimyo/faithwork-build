<?php

namespace App\Auth\Service;

use App\Auth\Entity\Token;
use App\Auth\Storage\TokenTypeStorage;
use Firebase\JWT\JWT;
use Psr\Container\ContainerInterface;
use Firebase\JWT\Key;
use stdClass;

class TokenService
{
    private string $secretKey;

    private const HS256 = 'HS256';

    // hour in seconds
    private const AUTH_TOKEN_LIFETIME = 60 * 60;

    // week in seconds
    private const REFRESH_TOKEN_LIFETIME = 60 * 60 * 24 * 7;

    private array $payloadFields = ['email'];

    public function __construct(ContainerInterface $container)
    {
        $this->secretKey = $container->get('secretKey');
    }


    public function createToken(int $userId, array $payload): ?Token
    {
        return $this->validatePayloadFields($payload)
            ? new Token(
                $userId,
                $this->buildToken($userId, $payload, TokenTypeStorage::AUTH, self::AUTH_TOKEN_LIFETIME),
                $this->buildToken($userId, $payload, TokenTypeStorage::REFRESH, self::REFRESH_TOKEN_LIFETIME)
            )
            : null;
    }


    protected function validatePayloadFields(array $payload): bool
    {
        foreach ($this->payloadFields as $field) {
            if (!isset($payload[$field])) {
                return false;
            }
        }

        return true;
    }

    protected function buildToken(int $userId, array $payload, string $type, int $lifetime): string
    {
        $token = [
            'userId' => $userId,
            'type' => $type,
            'exp' => $this->getExpiresIn($lifetime),
            'payload' => $payload
        ];

        return JWT::encode($token, $this->secretKey, self::HS256);
    }

    public function decode(string $token): stdClass
    {
        $headers = new stdClass();

        return JWT::decode($token, new Key($this->secretKey, self::HS256), $headers);
    }

    protected function getExpiresIn(int $lifetime): int
    {
        return time() + $lifetime;
    }
}
