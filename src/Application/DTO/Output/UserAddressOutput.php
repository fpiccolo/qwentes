<?php
declare(strict_types=1);

namespace App\Application\DTO\Output;

class UserAddressOutput
{
    public string $street;
    public string $city;
    public string $postalCode;
    public string $countryCode;
    public ?UserAddressCoordinatesOutput $coordinates;

    public function __construct(

        string                  $street,
        string                  $city,
        string                  $postalCode,
        string                  $countryCode,
        ?UserAddressCoordinatesOutput $coordinates

    )
    {
        $this->street = $street;
        $this->city = $city;
        $this->postalCode = $postalCode;
        $this->countryCode = $countryCode;
        $this->coordinates = $coordinates;
    }
}