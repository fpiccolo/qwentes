<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\Table;
use Ramsey\Uuid\UuidInterface;

#[Entity, Table(name: 'user_address')]
class UserAddress
{
    #[Id, Column(type: 'uuid')]
    private UuidInterface $id;

    #[Column(type: 'string')]
    private string $street;

    #[Column(type: 'string')]
    private string $city;

    #[Column(type: 'string')]
    private string $postalCode;

    #[Column(type: 'string')]
    private string $countryCode;

    #[OneToOne(targetEntity: UserAddressCoordinates::class, cascade: ['persist', 'remove'])]
    #[JoinColumn(name: 'coordinates_id', referencedColumnName: 'id', nullable: true)]
    private ?UserAddressCoordinates $coordinates = null;

    public function __construct(
        UuidInterface           $id,
        string                  $street,
        string                  $city,
        string                  $postalCode,
        string                  $countryCode,
    )
    {
        $this->id = $id;
        $this->street = $street;
        $this->city = $city;
        $this->postalCode = $postalCode;
        $this->countryCode = $countryCode;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }


    public function getStreet(): string
    {
        return $this->street;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }

    public function getCountryCode(): string
    {
        return $this->countryCode;
    }

    public function getCoordinates(): ?UserAddressCoordinates
    {
        return $this->coordinates;
    }

    public function setCoordinates(?UserAddressCoordinates $coordinates): void
    {
        $this->coordinates = $coordinates;
    }

}