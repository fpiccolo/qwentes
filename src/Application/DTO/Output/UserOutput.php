<?php
declare(strict_types=1);

namespace App\Application\DTO\Output;

class UserOutput
{
    public string $givenName;
    public string $familyName;
    public string $email;
    public ?string $dateOfBirth;
    public string $createdAt;
    public ?UserAddressOutput $address;

    public function __construct(
        string                  $givenName,
        string                  $familyName,
        string                  $email,
        ?string                  $dateOfBirth,
        string                  $createdAt,
        ?UserAddressOutput $address
    )
    {
        $this->givenName = $givenName;
        $this->familyName = $familyName;
        $this->email = $email;
        $this->dateOfBirth = $dateOfBirth;
        $this->createdAt = $createdAt;
        $this->address = $address;
    }
}