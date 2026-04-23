<?php

namespace App\User\Application;

use App\Entity\User;
use App\Security\AppCustomAuthenticator;
use App\User\Domain\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class ResetPassword
{
    public function execute(User $user, string $password, UserPasswordHasherInterface $userPasswordHasher, UserRepository $userRepository, Security $security): Response
    {
        $user->setPassword($userPasswordHasher->hashPassword($user, $password));
        $userRepository->saveUser($user);
        return $security->login($user, AppCustomAuthenticator::class, 'main');
    }
}
