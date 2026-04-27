<?php

namespace App\User\Application;

use App\User\Domain\Input\LoginUserDTO;
use App\User\Domain\Input\RegisterUserDTO;
use App\User\Domain\Repository\UserRepository;
use App\User\Infrastructure\AppCustomAuthenticator;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;

class LoginUser
{
    private UserRepository $userRepository;
    private Security $security;

    public function __construct(UserRepository $userRepository, Security $security)
    {
        $this->userRepository = $userRepository;
        $this->security = $security;
    }

    public function execute(LoginUserDTO $userDTO): Response
    {
        $user = $this->userRepository->findOneBy(['email' => $userDTO->email]);
        return $this->security->login($user, AppCustomAuthenticator::class, 'main');
    }
}
