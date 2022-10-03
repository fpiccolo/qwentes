<?php
declare(strict_types=1);

namespace App\Application\Exception;

class UserNotFountException extends NotFoundException
{
    public function __construct(string $email)
    {
        parent::__construct("User [$email] not found");
    }
}