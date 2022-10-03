<?php
declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\DTO\Input\PostInput;
use App\Application\Manager\CreatePostManager;
use App\Domain\Enum\PostStatus;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\Serializer\SerializerInterface;

class CreatePostController
{
    private CreatePostManager $createPostManager;

    public function __construct(
        CreatePostManager   $createPostManager,
    )
    {
        $this->createPostManager = $createPostManager;
    }

    public function __invoke(RequestInterface $request): ResponseInterface
    {

        $body = json_decode($request->getBody()->getContents(), true);

        $postInput = new PostInput(
            $body['title'],
            $body['body'],
            PostStatus::from($body['status']),
            $body['tags']
        );

        return new JsonResponse($this->createPostManager->createPost($postInput));
    }
}