<?php
declare(strict_types=1);

namespace App\Application\Manager;

use App\Application\DTO\Input\SearchUserInput;
use App\Application\DTO\Output\SearchUserOutput;
use App\Application\DTO\Output\UserAddressCoordinatesOutput;
use App\Application\DTO\Output\UserAddressOutput;
use App\Application\DTO\Output\UserOutput;
use App\Application\Translator\UserTranslator;
use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;

class SearchUserManager
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

    public function search(SearchUserInput $searchUserInput): SearchUserOutput
    {
        list($users, $totalItems, $pageCount) = $this->userRepository->searchUser(
            $searchUserInput->page,
            $searchUserInput->perPage,
            $searchUserInput->email,
            $searchUserInput->countryCode,
            $searchUserInput->sort,
        );

        $userOutput = [];
        /** @var User $user */
        foreach ($users as $user){
            $userOutput[] = $this->userTranslator->fromUserToUserOutput($user);
        }

        return new SearchUserOutput(
            $totalItems,
            $userOutput
        );
    }
}