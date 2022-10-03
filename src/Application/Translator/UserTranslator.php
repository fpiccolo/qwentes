<?php
declare(strict_types=1);

namespace App\Application\Translator;

use App\Application\DTO\Output\UserAddressCoordinatesOutput;
use App\Application\DTO\Output\UserAddressOutput;
use App\Application\DTO\Output\UserOutput;
use App\Domain\Entity\User;

class UserTranslator
{
    public function fromUserToUserOutput(User $user): UserOutput
    {
        $address = null;

        if(null !== $user->getAddress()){

            $coordinates = null;

            if(null !== $user->getAddress()->getCoordinates()){
                $coordinates = new UserAddressCoordinatesOutput(
                    $user->getAddress()->getCoordinates()->getLat(),
                    $user->getAddress()->getCoordinates()->getLng()
                );
            }


            $address = new UserAddressOutput(
                $user->getAddress()->getStreet(),
                $user->getAddress()->getCity(),
                $user->getAddress()->getPostalCode(),
                $user->getAddress()->getCountryCode(),
                $coordinates
            );
        }



        return new UserOutput(
            $user->getGivenName(),
            $user->getFamilyName(),
            $user->getEmail(),
            $user->getDateOfBirth()?->format('Y-m-d'),
            $user->getCreatedAt()->format('Y-m-d H:i:s'),
            $address
        );
    }
}