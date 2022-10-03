<?php
declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Manager\LoginManager;
use App\Application\DTO\Input\LoginInput;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class LoginController
{

    private LoginManager $loginManager;

    public function __construct(
        LoginManager $loginManager
    )
    {
        $this->loginManager = $loginManager;
    }

    public function __invoke(
        RequestInterface $request
    ): ResponseInterface
    {
        $body = json_decode($request->getBody()->getContents(), true);


        $input = new LoginInput(
            $body['email'],
            $body['password'],
        );

        return new JsonResponse(
            $this->loginManager->login($input)
        );
    }
}