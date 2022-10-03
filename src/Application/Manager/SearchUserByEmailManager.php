<?php
declare(strict_types=1);

namespace App\Application\Manager;

use App\Application\Exception\UserNotFountException;
use App\Application\Translator\UserTranslator;
use App\Domain\Repository\UserRepositoryInterface;

class SearchUserByEmailManager
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

    public function search(string $email)
    {
        $user = $this->userRepository->findUserByEmail($email);

        if(null === $user){
            throw new UserNotFountException($email);
        }

        return $this->userTranslator->fromUserToUserOutput($user);
    }
}