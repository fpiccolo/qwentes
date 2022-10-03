<?php
declare(strict_types=1);

namespace App\Application\DTO\Output;

class UserAddressCoordinatesOutput
{
    public string $lat;
    public string $lng;

    public function __construct(
        string        $lat,
        string        $lng
    )
    {
        $this->lat = $lat;
        $this->lng = $lng;
    }
}