<?php
declare(strict_types=1);

namespace App\Application\Manager;

use App\Application\Exception\InvalidCredentialsException;
use App\Application\Service\JWTService;
use App\Application\DTO\Input\LoginInput;
use App\Application\DTO\Output\LoginOutput;
use App\Domain\Repository\UserRepositoryInterface;
use App\Infrastructure\Repository\UserRepository;
use Firebase\JWT\JWT;

class LoginManager
{
    private UserRepositoryInterface $userRepository;
    private JWTService $JWTService;

    public function __construct(
        UserRepositoryInterface $userRepository,
        JWTService $JWTService
    )
    {
        $this->userRepository = $userRepository;
        $this->JWTService = $JWTService;
    }

    public function login(LoginInput $input): LoginOutput
    {
        $user = $this->userRepository->getByUsernameAndPassword(
            $input->email,
            $input->password
        );

        if(null === $user){
            throw new InvalidCredentialsException($input->email);
        }

        $jwt = $this->JWTService->createJWT($user);

        return new LoginOutput($jwt);
    }
}