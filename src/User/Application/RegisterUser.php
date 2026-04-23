<?php

namespace App\User\Application;

use App\User\Application\DTO\UserDTO;
use App\User\Domain\Entity\User;
use App\User\Domain\Repository\UserRepository;
use App\User\Infrastructure\AppCustomAuthenticator;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterUser
{
    public function execute(UserDTO $userDTO, UserRepository $userRepository, UserPasswordHasherInterface $hasher,Security $security): Response
    {
        $password = $hasher->hashPassword(
            User::createUser($userDTO->email, ''),
            $userDTO->password
        );

        $user = User::createUser($userDTO->email, $password);
        $userRepository->saveUser($user);

        return $security->login($user, AppCustomAuthenticator::class, 'main');
    }
}
