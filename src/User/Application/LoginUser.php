<?php

namespace App\User\Application;

use App\User\Application\DTO\UserDTO;
use App\User\Domain\Repository\UserRepository;
use App\User\Infrastructure\AppCustomAuthenticator;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class LoginUser
{
    public function execute(UserDTO $userDTO, UserPasswordHasherInterface $userPasswordHasher, UserRepository $userRepository, Security $security): Response
    {
        $user = $userRepository->findUserByEmail($userDTO->email);
        return $security->login($user, AppCustomAuthenticator::class, 'main');
    }
}
