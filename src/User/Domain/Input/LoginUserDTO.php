<?php

namespace App\User\Domain\Input;
use Symfony\Component\Validator\Constraints as Assert;

class LoginUserDTO
{
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 6, max: 4096)]
    public string $plainPassword;

    public function __construct(string $email = '', string $password ='')
    {
        $this->email = $email;
        $this->plainPassword = $password;
    }
}
