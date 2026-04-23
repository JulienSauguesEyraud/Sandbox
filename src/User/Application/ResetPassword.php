<?php

namespace App\User\Application;

use App\User\Domain\Entity\User;
use App\User\Domain\Repository\UserRepository;
use App\User\Infrastructure\AppCustomAuthenticator;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ResetPassword
{
    public function execute(User $user, string $password, UserPasswordHasherInterface $userPasswordHasher, UserRepository $userRepository, Security $security): Response
    {
        $user->resetPassword($userPasswordHasher->hashPassword($user, $password));
        $userRepository->saveUser($user);
        return $security->login($user, AppCustomAuthenticator::class, 'main');
    }
}
