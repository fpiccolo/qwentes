<?php
declare(strict_types=1);

namespace App\Application\Exception;

class InvalidCredentialsException extends BadRequestException
{
    public function __construct(string $email)
    {
        parent::__construct("Invalid credential for email [{$email}]");
    }
}