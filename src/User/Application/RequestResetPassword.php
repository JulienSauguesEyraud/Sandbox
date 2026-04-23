<?php

namespace App\User\Application;

use App\User\Application\DTO\EmailDTO;
use App\User\Domain\Entity\User;
use App\User\Domain\Repository\UserRepository;
use App\User\Infrastructure\AppCustomAuthenticator;
use PharIo\Manifest\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelper;

class RequestResetPassword
{
    private UserRepository $userRepository;
    private Mailer $mailer;
    private ResetPasswordHelper $resetPasswordHelper;

    public function __construct($userRepository, Mailer $mailer, ResetPasswordHelper $resetPasswordHelper)
    {
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
        $this->resetPasswordHelper = $resetPasswordHelper;
    }

    public function execute(EmailDTO $dto): void
    {
        $user = $this->userRepository->findUserByEmail($dto->email);

        if (!$user) {
            return;
        }

        $resetToken = $this->resetPasswordHelper->generateResetToken($user);

        $email = (new TemplatedEmail())
            ->from(new Address('mailer@test.com'))
            ->to($user->getEmail())
            ->subject('Reset password')
            ->htmlTemplate('reset_password/email.html.twig')
            ->context([
                'resetToken' => $resetToken,
            ]);

        $this->mailer->send($email);
    }
}
