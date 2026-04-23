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
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $hasher;
    private Security $security;

    public function __construct(UserRepository $userRepository, UserPasswordHasherInterface $hasher, Security $security)
    {
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
        $this->security = $security;
    }
    public function execute(UserDTO $userDTO): Response
    {
        $password = $this->hasher->hashPassword(
            User::createUser($userDTO->email, ''),
            $userDTO->password
        );

        $user = User::createUser($userDTO->email, $password);
        $this->userRepository->saveUser($user);

        return $this->security->login($user, AppCustomAuthenticator::class, 'main');
    }
}
