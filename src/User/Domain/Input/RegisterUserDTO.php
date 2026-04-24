<?php

namespace App\User\Domain\Input;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterUserDTO
{
    #[Assert\NotBlank]
    #[Assert\Email]
    public string $email;

    #[Assert\NotBlank]
    #[Assert\Length(min: 6, max: 4096)]
    public string $plainPassword;

    #[Assert\IsTrue(message: "You should accept terms.")]
    public bool $agreeTerms = false;

    public function __construct(string $email = '', string $password ='', bool $agreeTerms = false)
    {
        $this->email = $email;
        $this->plainPassword = $password;
        $this->agreeTerms = $agreeTerms;
    }
}
