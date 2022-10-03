<?php
declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\DTO\Input\CreateUserInput;
use App\Application\Manager\CreateUserManager;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\RequestInterface;
use Symfony\Component\Serializer\SerializerInterface;

class CreateUserController
{

    private CreateUserManager $createUserManager;
    private SerializerInterface $serializer;

    public function __construct(
        CreateUserManager $createUserManager,
        SerializerInterface $serializer,
    )
    {
        $this->createUserManager = $createUserManager;
        $this->serializer = $serializer;
    }

    public function __invoke(RequestInterface $request)
    {

        $body = $request->getBody()->getContents();

        $createUserInput = $this->serializer->deserialize($body, CreateUserInput::class, 'json');

        return new JsonResponse($this->createUserManager->createUser($createUserInput));
    }
}