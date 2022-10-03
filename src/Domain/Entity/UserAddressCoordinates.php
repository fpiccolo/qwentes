<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Ramsey\Uuid\UuidInterface;

#[Entity, Table(name: 'user_address_coordinates')]
class UserAddressCoordinates
{
    #[Id, Column(type: 'uuid')]
    private UuidInterface $id;

    #[Column(type: 'string')]
    private string $lat;

    #[Column(type: 'string')]
    private string $lng;

    public function __construct(
        UuidInterface $id,
        string        $lat,
        string        $lng
    )
    {
        $this->id = $id;
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }


    public function getLat(): string
    {
        return $this->lat;
    }

    public function getLng(): string
    {
        return $this->lng;
    }


}