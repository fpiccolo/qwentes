<?php
declare(strict_types=1);

namespace App\Infrastructure\Middleware;

use App\Application\Service\JWTService;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Psr7\Response;

class RequestMiddleware
{

    private const CONTENT_TYPE = 'application/json';
    private const ACCEPT = 'application/json';
    private JWTService $JWTService;

    public function __construct(
        JWTService $JWTService
    )
    {
        $this->JWTService = $JWTService;
    }

    public function __invoke(\GuzzleHttp\Psr7\ServerRequest $request, RequestHandlerInterface $handler)
    {
        $contentType = $request->getHeaderLine('Content-type');
        $accept = $request->getHeaderLine('Accept');

        if($contentType !== self::CONTENT_TYPE || $accept !== self::ACCEPT){
            throw new \Exception('HEADER not valid', 400);
        }

        if('/login' !== $request->getRequestTarget()) {
            $authorization = $request->getHeaderLine('Authorization');


            if(empty($authorization)){
                throw new \Exception('Authorization required', 500);
            }

            if(!str_starts_with($authorization, 'Bearer ')){
                throw new \Exception('Authorization not valid', 500);
            }

            $authorization = explode(' ', $authorization);

            $this->JWTService->validate(end($authorization));
        }

        return $handler->handle($request);;
    }
}