<?php
declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\Manager\GetPostManager;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Ramsey\Uuid\Uuid;

class GetPostController
{
    private GetPostManager $getPostManager;

    public function __construct(
        GetPostManager $getPostManager
    )
    {
        $this->getPostManager = $getPostManager;
    }

    public function __invoke(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        return new JsonResponse(
            $this->getPostManager->getPost(Uuid::fromString($args['id']))
        );
    }
}