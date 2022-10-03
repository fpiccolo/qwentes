<?php
declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\DTO\Input\SearchUserInput;
use App\Application\Manager\SearchUserManager;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class SearchUserController
{
    private SearchUserManager $searchUserManager;

    public function __construct(
        SearchUserManager $searchUserManager
    )
    {
        $this->searchUserManager = $searchUserManager;
    }


    public function __invoke(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        $array =  [
            "sort" => [],
            "countryCode" => [],
            "email" => [],
            "page" => 1,
            "perPage" => 100
        ];
        foreach ($queryParams as $queryParam => $value){
                $array[$queryParam] = $value;
        }

        $input = new SearchUserInput(
            $array['sort'],
            $array['countryCode'],
            $array['email'],
            (int) $array['page'],
            (int) $array['perPage'],
        );

        return new JsonResponse(
            $this->searchUserManager->search($input)
        );
    }
}