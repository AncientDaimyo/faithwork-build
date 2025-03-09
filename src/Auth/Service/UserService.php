<?php

namespace App\Auth\Service;

use App\Auth\Entity\User;
use App\Auth\Repository\UserRepository;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserById(int $userId): ?User
    {
        $userData = $this->userRepository->getById($userId);

        if (!$userData) {
            return null;
        }

        return new User(
            $userData['id'],
            $userData['email'],
            $userData['password']
        );
    }

    public function getUserByEmail(string $email): ?User
    {
        $userData = $this->userRepository->getUserByEmail($email);

        if (!$userData) {
            return null;
        }

        return new User(
            $userData['id'],
            $userData['email'],
            $userData['password']
        );
    }

    public function userExist(string $email): bool
    {
        $userData = $this->userRepository->getUserByEmail($email);

        if (!$userData) {
            return false;
        }

        return true;
    }

    public function createUser(string $email, string $passwordHash): int
    {
        return $this->userRepository->insert(['email' => $email, 'password_hash' => $passwordHash]);
    }

    public function saveActivationCode(int $userId, string $code): void
    {
        $this->userRepository->update(['id' => $userId, 'activation_code' => $code]);
    }

    public function activateUser(string $activationCode): bool
    {
        $userData = $this->userRepository->getByActivationCode($activationCode);

        if (!$userData) {
            return false;
        }

        return $this->userRepository->update(['id' => $userData['id'], 'activation_code' => null, 'activated' => true]);
    }
}
