<?php

namespace App\User\Application\DTO;

class ResetPasswordDTO
{
    public string $password;
    public string $token;

    public function __construct(string $password = '', string $token = '')
    {
        $this->password = $password;
        $this->token = $token;
    }
}
