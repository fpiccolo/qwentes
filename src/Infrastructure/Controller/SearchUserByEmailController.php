<?php
declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\DTO\Input\SearchUserInput;
use App\Application\Manager\SearchUserByEmailManager;
use App\Application\Manager\SearchUserManager;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class SearchUserByEmailController
{
    private SearchUserByEmailManager $searchUserByEmailManager;

    public function __construct(
        SearchUserByEmailManager $searchUserByEmailManager
    )
    {
        $this->searchUserByEmailManager = $searchUserByEmailManager;
    }


    public function __invoke(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $email = $args['email'];

        return new JsonResponse(
            $this->searchUserByEmailManager->search($email)
        );
    }
}