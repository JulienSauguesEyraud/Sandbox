<?php

namespace App\User\Domain\Input;
use Symfony\Component\Validator\Constraints as Assert;

class ResetPasswordDTO
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 6, max: 4096)]
    public string $plainPassword;
    public string $token;

    public function __construct(string $password = '', string $token = '')
    {
        $this->plainPassword = $password;
        $this->token = $token;
    }
}
