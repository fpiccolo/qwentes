<?php
declare(strict_types=1);

namespace App\Application\Manager;

use App\Application\DTO\Input\CreateUserInput;
use App\Application\DTO\Output\UserOutput;
use App\Application\Service\PasswordValidator;
use App\Application\Translator\UserTranslator;
use App\Domain\Entity\User;
use App\Domain\Entity\UserAddress;
use App\Domain\Entity\UserAddressCoordinates;
use App\Domain\Repository\UserRepositoryInterface;
use Cake\Chronos\Chronos;
use Ramsey\Uuid\Uuid;

class CreateUserManager
{
    private UserRepositoryInterface $userRepository;
    private UserTranslator $userTranslator;
    private PasswordValidator $passwordValidator;

    public function __construct(
        UserRepositoryInterface $userRepository,
        UserTranslator $userTranslator,
        PasswordValidator $passwordValidator,
    )
    {
        $this->userRepository = $userRepository;
        $this->userTranslator = $userTranslator;
        $this->passwordValidator = $passwordValidator;
    }

    public function createUser(CreateUserInput $createUserInput): UserOutput
    {

        $this->passwordValidator->validate($createUserInput->email, $createUserInput->password);

        $user = new User(
            Uuid::uuid4(),
            $createUserInput->givenName,
            $createUserInput->familyName,
            $createUserInput->email,
            $createUserInput->password,
        );

        $user->setDateOfBirth(null !== $createUserInput->dateOfBirth ? Chronos::createFromFormat('Y-m-d', $createUserInput->dateOfBirth) : null);

        if(null !== $createUserInput->address){


            $address = new UserAddress(
                Uuid::uuid4(),
                $createUserInput->address->street,
                $createUserInput->address->city,
                $createUserInput->address->postalCode,
                $createUserInput->address->countryCode,
            );

            $user->setAddress($address);

            if(null !== $createUserInput->address->coordinates){
                $coordinates = new UserAddressCoordinates(
                    Uuid::uuid4(),
                    $createUserInput->address->coordinates->lat,
                    $createUserInput->address->coordinates->lng
                );

                $address->setCoordinates($coordinates);
            }

        }

        $this->userRepository->save($user);

        return $this->userTranslator->fromUserToUserOutput($user);
    }
}