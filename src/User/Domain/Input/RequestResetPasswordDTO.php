<?php

namespace App\User\Domain\Input;
use Symfony\Component\Validator\Constraints as Assert;

class RequestResetPasswordDTO
{
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    public function __construct(string $email = '')
    {
        $this->email = $email;
    }
}
