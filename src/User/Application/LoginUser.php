<?php

namespace App\User\Application;

use App\Entity\User;
use App\Security\AppCustomAuthenticator;
use App\User\Domain\Repository\UserRepository;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class LoginUser
{
    public function execute(string $email, string $password, UserPasswordHasherInterface $userPasswordHasher, UserRepository $userRepository, Security $security): Response
    {
        $user = $userRepository->findUserByEmail($email);
        if (!$user) {
            throw new AuthenticationException('User not found');
        }
        if(!$userPasswordHasher->isPasswordValid($user, $password)) {
            throw new AuthenticationException('Invalid password');
        }
        return $security->login($user, AppCustomAuthenticator::class, 'main');
    }
}
