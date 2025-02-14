<?php

namespace App\Auth\Application\Service;

use App\Auth\Application\Boundary\AuthServiceBoundary;
use App\Auth\Application\Provider\TokenProvider;
use App\Auth\Domain\Entity\Token;
use App\Auth\Infrastructure\Repository\UserTokenRepository;
use Psr\Container\ContainerInterface;
use App\Shared\Utility\Mailer\MailerService;
use Firebase\JWT\JWT;
use Slim\Psr7\Request;

class AuthService implements AuthServiceBoundary
{
    protected TokenProvider $tokenProvider;
    protected UserService $userService;

    protected string $domain;

    protected MailerService $mailerService;

    protected UserTokenRepository $userTokenRepository;

    public function __construct(
        ContainerInterface $container,
        TokenProvider $tokenProvider,
        UserService $userService,
        UserTokenRepository $userTokenRepository,
        MailerService $mailerService
    ) {
        $this->tokenProvider = $tokenProvider;
        $this->userService = $userService;
        $this->domain = $container->get('domain');
        $this->mailerService = $mailerService;
        $this->userTokenRepository = $userTokenRepository;
    }

    public function login(array $data): Token
    {
        if (!$this->validate($data)) {
            throw new \InvalidArgumentException('Invalid data');
        }

        $user = $this->userService->getUserByEmail($data['email']);

        if (!$user) {
            throw new \InvalidArgumentException('User not found');
        }

        if (!password_verify($data['password'], $user->passwordHash)) {
            throw new \InvalidArgumentException('Invalid password');
        }

        $token = $this->tokenProvider->createToken($user->id, [
            'email' => $user->email,
        ]);

        return $token;
    }

    public function register(array $data): void
    {
        if (!$this->validate($data)) {
            throw new \InvalidArgumentException('Invalid data');
        }

        if ($this->userService->userExist($data['email'])) {
            throw new \InvalidArgumentException('User already exists');
        }

        $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);

        $this->userService->createUser($data['email'], $passwordHash);

        $user = $this->userService->getUserByEmail($data['email']);

        $this->tokenProvider->createToken($user->id, [
            'email' => $user->email,
        ]);

        $activationCode = $this->generateActivationCode();

        $this->userService->saveActivationCode($user->id, $activationCode);

        $this->mailerService->sendEmail($user->email, $activationCode);
    }

    public function refresh(string $refreshToken): Token
    {
        try {
            $decoded = $this->tokenProvider->decodeRefreshToken($refreshToken);
        } catch (\InvalidArgumentException $e) {
            throw new \InvalidArgumentException('Invalid refresh token');
        }

        $user = $this->userService->getUserById($decoded->userId);
        if (!$user) {
            throw new \InvalidArgumentException('User not found');
        }

        $token = $this->tokenProvider->createToken($user->id, [
            'email' => $user->email,
        ]);

        return $token;
    }

    public function logout(array $data): void
    {
        if (!isset($data['userId'])) {
            throw new \InvalidArgumentException('User ID is required for logout');
        }

        $this->userTokenRepository->deleteTokensByUserId($data['userId']);
    }

    public function activateRegistration(string $activationCode): Token
    {
        $data = $this->userTokenRepository->getByActivationCode($activationCode);
        $this->userService->activateUser($activationCode);
        return new Token(
            (int)$data['user_id'],
            (string)$data['auth_token'],
            (string)$data['refresh_token'],
            (int)$data['kid']
        );
    }

    protected function validate(array $data): bool
    {
        // TODO implement validate
        return true;
    }

    protected function generateActivationCode(): string
    {
        return bin2hex(random_bytes(16));
    }

    protected function generateActivationLink(string $activationCode): string
    {
        return $this->domain . '/auth/activate?code=' . $activationCode;
    }

    public function auth(string $token): bool
    {
        try {
            $decoded = $this->tokenProvider->decodeAuthToken($token);
        } catch (\InvalidArgumentException $e) {
            return false;
        }

        if ($decoded->exp < time()) {
            return false;
        }

        $userId = $this->userTokenRepository->getUserIdByToken($token);
        if (!$userId) {
            return false;
        }

        return true;
    }

    public function checkRequest(Request $request): bool
    {
        $token = $request->getHeaderLine('Authorization');
        if (!$token) {
            return false;
        }
        return $this->auth($token);
    }
}
