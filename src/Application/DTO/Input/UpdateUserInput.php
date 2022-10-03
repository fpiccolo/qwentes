<?php
declare(strict_types=1);

namespace App\Application\DTO\Input;

class UpdateUserInput
{
    public string $givenName;
    public string $familyName;
    public string $email;
    public ?string $dateOfBirth;
    public ?CreateUserAddressInput $address;

    public function __construct(
        string $givenName,
        string $familyName,
        string $email,
        ?string $dateOfBirth,
        ?CreateUserAddressInput $address
    )
    {
        $this->givenName = $givenName;
        $this->familyName = $familyName;
        $this->email = $email;
        $this->dateOfBirth = $dateOfBirth;
        $this->address = $address;
    }
}