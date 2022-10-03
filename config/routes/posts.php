<?php
declare(strict_types=1);

/** @var App $app */

use App\Infrastructure\Controller\CreatePostController;
use App\Infrastructure\Controller\GetPostController;
use App\Infrastructure\Controller\SearchPostController;
use App\Infrastructure\Controller\UpdatePostController;
use Slim\App;


$app->group('/posts', function () use ($app): void {
    $app->post('/posts', CreatePostController::class);
    $app->get('/posts', SearchPostController::class);
    $app->get('/posts/{id}', GetPostController::class);
    $app->put('/posts/{id}', UpdatePostController::class);
});
