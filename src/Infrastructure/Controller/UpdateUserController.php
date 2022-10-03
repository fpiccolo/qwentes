<?php
declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\DTO\Input\UpdateUserInput;
use App\Application\Manager\UpdateUserManager;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UpdateUserController
{
    private UpdateUserManager $updateUserManager;
    private SerializerInterface $serializer;

    public function __construct(
        UpdateUserManager   $updateUserManager,
        SerializerInterface $serializer,
    )
    {
        $this->updateUserManager = $updateUserManager;
        $this->serializer = $serializer;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $email = $args['email'];
        $body = $request->getBody()->getContents();

        $createUserInput = $this->serializer->deserialize($body, UpdateUserInput::class, 'json');

        return new JsonResponse($this->updateUserManager->updateUser($email, $createUserInput));
    }
}