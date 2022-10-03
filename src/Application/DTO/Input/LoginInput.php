<?php
declare(strict_types=1);

namespace App\Application\DTO\Input;

class LoginInput
{
    public string $email;
    public string $password;

    public function __construct(
        string $email,
        string $password
    )
    {
        $this->email = $email;
        $this->password = $password;
    }
}