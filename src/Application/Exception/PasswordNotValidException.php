<?php
declare(strict_types=1);

namespace App\Application\Exception;

class PasswordNotValidException extends BadRequestException
{
    public function __construct()
    {
        parent::__construct('Password not valid');
    }
}