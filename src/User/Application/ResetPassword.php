<?php

namespace App\User\Application;

use App\User\Application\DTO\ResetPasswordDTO;
use App\User\Domain\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

class ResetPassword
{
    private UserRepository $userRepository;
    private Security $security;
    private ResetPasswordHelperInterface $resetPasswordHelper;
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserRepository $userRepository, Security $security, ResetPasswordHelperInterface $resetPasswordHelper, UserPasswordHasherInterface $hasher)
    {
        $this->userRepository = $userRepository;
        $this->security = $security;
        $this->resetPasswordHelper = $resetPasswordHelper;
        $this->hasher = $hasher;
    }
    public function execute(ResetPasswordDTO $resetPasswordDTO): void
    {
        try {
            $user = $this->resetPasswordHelper->validateTokenAndFetchUser($resetPasswordDTO->token);
        } catch (\Throwable $e) {
            throw new AuthenticationException('Invalid or expired token');
        }
        $hashedPassword = $this->hasher->hashPassword($user, $resetPasswordDTO->password);

        $user->resetPassword($hashedPassword);

        $this->userRepository->saveUser($user);

        $this->resetPasswordHelper->removeResetRequest($resetPasswordDTO->token);
    }
}
