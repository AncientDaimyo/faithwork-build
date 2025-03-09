<?php

namespace App\Auth\Service;

use App\Auth\Service\TokenService;
use App\Auth\Entity\User;
use App\Auth\Interface\AuthServiceInterface;
use App\Auth\Entity\Token;
use App\Auth\Repository\UserTokenRepository;
use App\Auth\Storage\TokenTypeStorage;
use App\Shared\Utility\Mailer\MailerService;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Request;

class AuthService implements AuthServiceInterface
{
    protected string $domain;

    protected TokenService $tokenService;

    protected UserService $userService;

    protected MailerService $mailerService;

    protected UserTokenRepository $userTokenRepository;

    public function __construct(
        ContainerInterface $container,
        TokenService $tokenService,
        UserService $userService,
        UserTokenRepository $userTokenRepository,
        MailerService $mailerService
    ) {
        $this->tokenService = $tokenService;
        $this->userService = $userService;
        $this->domain = $container->get('domain');
        $this->mailerService = $mailerService;
        $this->userTokenRepository = $userTokenRepository;
    }

    public function login(string $email, string $password): ?Token
    {
        $user = $this->userService->getUserByEmail($email);

        if (empty($user) || !password_verify($password, $user->passwordHash)) {
            return null;
        }

        $token = $this->tokenService->createToken($user->id, [
            'email' => $user->email,
        ]);

        $this->userTokenRepository->saveToken($user->id, $token);

        return $token;
    }

    public function register(string $email, string $password): null|array
    {
        if ($this->userService->userExist($email)) {
            return ['error' => 'User already exists'];
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $this->userService->createUser($email, $passwordHash);

        $user = $this->userService->getUserByEmail($email);

        if (empty($user)) {
            return ['error' => 'User creation error'];
        }

        $activationCode = $this->generateActivationCode();

        $this->userService->saveActivationCode($user->id, $activationCode);

        $this->mailerService->sendEmail($user->email, $activationCode);

        return null;
    }

    public function refresh(string $refreshToken): ?Token
    {
        try {
            $decoded = $this->tokenService->decode($refreshToken);
        } catch (\Exception $e) {
            return null;
        }

        if (
            empty($decoded) ||
            empty($decoded->userId) ||
            $decoded->type !== TokenTypeStorage::REFRESH
        ) {
            return null;
        }

        $userId = $this->userTokenRepository->getUserIdByRefreshToken($refreshToken);

        if (empty($userId)) {
            return null;
        }

        $user = $this->userService->getUserById($userId);

        if (empty($user)) {
            return null;
        }

        $token = $this->tokenService->createToken($user->id, [
            'email' => $user->email,
        ]);

        $this->userTokenRepository->saveToken($user->id, $token);

        return $token;
    }

    public function logout(int $userId): void
    {
        $this->userTokenRepository->deleteTokensByUserId($userId);
    }

    public function activateRegistration(string $activationCode): Token
    {
        // TODO rewrite activation
        $data = $this->userTokenRepository->getByActivationCode($activationCode);
        $this->userService->activateUser($activationCode);
        return new Token(
            (int)$data['user_id'],
            (string)$data['auth_token'],
            (string)$data['refresh_token'],
            (int)$data['kid']
        );
    }

    protected function generateActivationCode(): string
    {
        return bin2hex(random_bytes(16));
    }

    protected function generateActivationLink(string $activationCode): string
    {
        return $this->domain . '/auth/activate?code=' . $activationCode;
    }

    public function auth(Request $request): ?User
    {
        $token = $this->extractToken($request);

        if (empty($token)) {
            return null;
        }
        try {
            $decoded = $this->tokenService->decode($token);
        } catch (\Exception $e) {
            return null;
        }

        if (
            empty($decoded) ||
            empty($decoded->userId) ||
            $decoded->type !== TokenTypeStorage::AUTH
        ) {
            return null;
        }

        $userId = $this->userTokenRepository->getUserIdByToken($token);

        if (empty($userId)) {
            return null;
        }

        return $this->userService->getUserById($userId);
    }

    protected function extractToken(Request $request): ?string
    {
        $token = $request->getHeaderLine('Authorization');
        if (empty($token)) {
            return null;
        }

        if (preg_match('/Bearer\s(\S+)/', $token, $matches)) {
            $token = $matches[1] ?? null;
        }

        return $token;
    }
}
