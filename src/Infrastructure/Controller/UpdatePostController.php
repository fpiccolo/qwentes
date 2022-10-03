<?php
declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\DTO\Input\PostInput;
use App\Application\Manager\CreatePostManager;
use App\Application\Manager\UpdatePostManager;
use App\Domain\Enum\PostStatus;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Serializer\SerializerInterface;

class UpdatePostController
{
    private UpdatePostManager $updatePostManager;

    public function __construct(
        UpdatePostManager   $updatePostManager,
    )
    {
        $this->updatePostManager = $updatePostManager;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {

        $body = json_decode($request->getBody()->getContents(), true);

        $postInput = new PostInput(
            $body['title'],
            $body['body'],
            PostStatus::from($body['status']),
            $body['tags']
        );

        return new JsonResponse($this->updatePostManager->updatePost(Uuid::fromString($args['id']), $postInput));
    }
}