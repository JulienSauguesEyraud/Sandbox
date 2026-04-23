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
    private UserRepository $userRepository;
    private Security $security;

    public function __construct(UserRepository $userRepository, Security $security)
    {
        $this->userRepository = $userRepository;
        $this->security = $security;
    }

    public function execute(UserDTO $userDTO): Response
    {
        $user = $this->userRepository->findUserByEmail($userDTO->email);
        return $this->security->login($user, AppCustomAuthenticator::class, 'main');
    }
}
