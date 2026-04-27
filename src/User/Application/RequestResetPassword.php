<?php

namespace App\User\Application;

use App\User\Domain\Input\RequestResetPasswordDTO;
use App\User\Domain\Repository\UserRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

class RequestResetPassword
{
    private UserRepository $userRepository;
    private MailerInterface $mailer;
    private ResetPasswordHelperInterface $resetPasswordHelper;

    public function __construct(UserRepository $userRepository, MailerInterface $mailer, ResetPasswordHelperInterface $resetPasswordHelper)
    {
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
        $this->resetPasswordHelper = $resetPasswordHelper;
    }

    public function execute(RequestResetPasswordDTO $dto): void
    {
        $user = $this->userRepository->findOneBy(['email' => $dto->email]);

        if (!$user) {
            return;
        }

        $resetToken = $this->resetPasswordHelper->generateResetToken($user);

        $email = new TemplatedEmail()
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
