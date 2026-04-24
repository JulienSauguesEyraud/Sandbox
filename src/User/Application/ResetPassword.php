<?php

namespace App\User\Application;

use App\User\Domain\Entity\User;
use App\User\Domain\Input\ResetPasswordDTO;
use App\User\Domain\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ResetPassword
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $hasher)
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
    }
    public function execute(ResetPasswordDTO $resetPasswordDTO, User $user): void
    {
        $hashedPassword = $this->hasher->hashPassword($user, $resetPasswordDTO->plainPassword);

        $user->resetPassword($hashedPassword);

        $this->userRepository->saveUser($user);
    }
}
