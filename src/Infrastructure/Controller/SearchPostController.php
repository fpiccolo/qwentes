<?php
declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\DTO\Input\SearchPostInput;
use App\Application\DTO\Input\SearchUserInput;
use App\Application\Manager\SearchPostManager;
use App\Application\Manager\SearchUserManager;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class SearchPostController
{
    private SearchPostManager $searchPostManager;

    public function __construct(
        SearchPostManager $searchPostManager
    )
    {
        $this->searchPostManager = $searchPostManager;
    }


    public function __invoke(RequestInterface $request, ResponseInterface $response, array $args): ResponseInterface
    {
        $queryParams = $request->getQueryParams();

        $array =  [
            "q" => "",
            "tags" => [],
            "page" => 1,
            "perPage" => 100
        ];
        foreach ($queryParams as $queryParam => $value){
                $array[$queryParam] = $value;
        }

        $input = new SearchPostInput(
            $array['q'],
            $array['tags'],
            (int) $array['page'],
            (int) $array['perPage'],
        );

        return new JsonResponse(
            $this->searchPostManager->search($input)
        );
    }
}