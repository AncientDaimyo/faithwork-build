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

    public function getActivatedUserByEmail(string $email): ?User
    {
        $userData = $this->userRepository->getUserByEmail($email, true);

        if (!$userData) {
            return null;
        }

        return new User(
            $userData['id'],
            $userData['email'],
            $userData['password']
        );
    }

    /*************  ✨ Codeium Command ⭐  *************/
    /**
     * Check if user with given email already exists in the database
     *
     * @param string $email
     *
     * @return bool
     */
    /******  c8a9bd41-b76e-426a-929e-62fa538230f1  *******/
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
        return $this->userRepository->createUser($email, $passwordHash);
    }

    public function saveActivationCode(int $userId, string $code): void
    {
        $this->userRepository->update(['id' => $userId, 'activation_code' => $code]);
    }

    public function activateUser(string $activationCode, int $userId): bool
    {
        return $this->userRepository->update(['id' => $userId, 'activation_code' => null, 'activated' => true]);
    }

    public function isUserActivated(int $userId): bool
    {
        return $this->userRepository->getById($userId)['activated'];
    }

    public function getByActivationCode(string $activationCode): ?User
    {
        $userData = $this->userRepository->getByActivationCode($activationCode);

        if (!$userData || empty($userData['id']) || empty($userData['email']) || empty($userData['password'])) {
            return null;
        }

        return new User(
            $userData['id'],
            $userData['email'],
            $userData['password']
        );
    }
}
