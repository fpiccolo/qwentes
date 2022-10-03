<?php
declare(strict_types=1);

/** @var App $app */

use App\Infrastructure\Controller\CreateUserController;
use App\Infrastructure\Controller\SearchUserByEmailController;
use App\Infrastructure\Controller\SearchUserController;
use App\Infrastructure\Controller\UpdateUserController;
use App\Infrastructure\Middleware\AuthorizationMiddleware;
use App\Infrastructure\Middleware\HeaderValidatorMiddleware;
use Slim\App;


$app->group('/users', function () use ($app): void {
    $app->post('/users', CreateUserController::class);
    $app->get('/users', SearchUserController::class);
    $app->get('/users/{email}', SearchUserByEmailController::class);
    $app->put('/users/{email}', UpdateUserController::class);
});
