<?php
declare(strict_types=1);

namespace App\Application\Manager;

use App\Application\DTO\Input\UpdateUserInput;
use App\Application\DTO\Output\UserOutput;
use App\Application\Exception\UserNotFountException;
use App\Application\Translator\UserTranslator;
use App\Domain\Entity\User;
use App\Domain\Entity\UserAddress;
use App\Domain\Entity\UserAddressCoordinates;
use App\Domain\Repository\UserRepositoryInterface;
use Cake\Chronos\Chronos;
use Ramsey\Uuid\Uuid;

class UpdateUserManager
{
    private UserRepositoryInterface $userRepository;
    private UserTranslator $userTranslator;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserTranslator $userTranslator
    )
    {
        $this->userRepository = $userRepository;
        $this->userTranslator = $userTranslator;
    }

    public function updateUser(string $email, UpdateUserInput $updateUserInput): UserOutput
    {
        $user = $this->userRepository->findUserByEmail($email);

        if(null === $user){
            throw new UserNotFountException($email);
        }

        $user->setGivenName($updateUserInput->givenName);
        $user->setFamilyName($updateUserInput->familyName);
        $user->setEmail($updateUserInput->email);

        $user->setDateOfBirth(null !== $updateUserInput->dateOfBirth ? Chronos::createFromFormat('Y-m-d', $updateUserInput->dateOfBirth) : null);

        $address = null;
        if(null !== $updateUserInput->address){


            $address = new UserAddress(
                Uuid::uuid4(),
                $updateUserInput->address->street,
                $updateUserInput->address->city,
                $updateUserInput->address->postalCode,
                $updateUserInput->address->countryCode,
            );



            if(null !== $updateUserInput->address->coordinates){
                $coordinates = new UserAddressCoordinates(
                    Uuid::uuid4(),
                    $updateUserInput->address->coordinates->lat,
                    $updateUserInput->address->coordinates->lng
                );

                $address->setCoordinates($coordinates);
            }

        }

        $user->setAddress($address);

        $this->userRepository->save($user);

        return $this->userTranslator->fromUserToUserOutput($user);
    }
}