<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Entity\UserAddress;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Doctrine\ORM\Mapping\PrePersist;
use Doctrine\ORM\Mapping\Table;
use Ramsey\Uuid\UuidInterface;

#[Entity, Table(name: 'user')]
class User
{
    #[Id, Column(type: 'uuid')]
    private UuidInterface $id;

    #[Column(type: 'string')]
    private string $givenName;

    #[Column(type: 'string')]
    private string $familyName;

    #[Column(type: 'string', unique: true)]
    private string $email;

    #[Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $dateOfBirth = null;

    #[Column(type: 'string')]
    private string $password;

    #[OneToOne(targetEntity: UserAddress::class, cascade: ['persist', 'remove'] )]
    #[JoinColumn(name: 'address_id', referencedColumnName: 'id', nullable: true)]
    private ?UserAddress $address = null;

    #[Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    public function __construct(
        UuidInterface $id,
        string $givenName,
        string $familyName,
        string $email,
        string $password,
    )
    {
        $this->id = $id;
        $this->givenName = $givenName;
        $this->familyName = $familyName;
        $this->email = $email;
        $this->password = $password;
        $this->setCreatedAt(new \DateTimeImmutable('now'));
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }


    public function getGivenName(): string
    {
        return $this->givenName;
    }

    public function getFamilyName(): string
    {
        return $this->familyName;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(?\DateTimeInterface $dateOfBirth): void
    {
        $this->dateOfBirth = $dateOfBirth;
    }



    public function getAddress(): ?UserAddress
    {
        return $this->address;
    }

    public function setAddress(?UserAddress $address): void
    {
        $this->address = $address;
    }

    public function getName(): string
    {
        return $this->getGivenName().' '.$this->getFamilyName();
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeImmutable $createdAt
     */
    private function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @param string $givenName
     */
    public function setGivenName(string $givenName): void
    {
        $this->givenName = $givenName;
    }

    /**
     * @param string $familyName
     */
    public function setFamilyName(string $familyName): void
    {
        $this->familyName = $familyName;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }



}