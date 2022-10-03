<?php
declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Exception\PasswordNotValidException;

class PasswordValidator
{
    public function validate(string $email, string $password): void
    {
        $localPartEmail = explode('@', $email)[0];

        if(!preg_match("/^(?=.{6,})(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[1-9])(?=.*?[,.:;\-_$%&()=]{2})(?!.*$localPartEmail).*$/", $password))
        {
            throw new PasswordNotValidException();
        }
    }
}