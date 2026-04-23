<?php

namespace App\User\Application\DTO;

class EmailDTO
{
    public string $email;

    public function __construct(string $email = '')
    {
        $this->email = $email;
    }
}
