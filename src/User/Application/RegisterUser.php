<?php

namespace App\User\Application;

use App\Entity\User;
use App\Security\AppCustomAuthenticator;
use App\User\Domain\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterUser
{
    public function execute(string $email, string $password, UserPasswordHasherInterface $userPasswordHasher, UserRepository $userRepository, Security $security): Response
    {
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($userPasswordHasher->hashPassword($user, $password));
        $user->setRoles(['ROLE_USER']);
        $userRepository->saveUser($user);

        return $security->login($user, AppCustomAuthenticator::class, 'main');
    }
}
