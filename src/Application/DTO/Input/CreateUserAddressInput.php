<?php
declare(strict_types=1);

namespace App\Application\DTO\Input;

use Ramsey\Uuid\UuidInterface;

class CreateUserAddressInput
{
    public string $street;
    public string $city;
    public string $postalCode;
    public string $countryCode;
    public ?CreateUserAddressCoordinatesInput $coordinates;

    public function __construct(
        string                  $street,
        string                  $city,
        string                  $postalCode,
        string                  $countryCode,
        ?CreateUserAddressCoordinatesInput $coordinates
    )
    {
        $this->street = $street;
        $this->city = $city;
        $this->postalCode = $postalCode;
        $this->countryCode = $countryCode;
        $this->coordinates = $coordinates;
    }
}