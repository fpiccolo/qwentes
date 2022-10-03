<?php
declare(strict_types=1);

namespace App\Application\DTO\Output;

class LoginOutput
{
    public string $jwt;

    public function __construct(string $jwt)
    {
        $this->jwt = $jwt;
    }
}