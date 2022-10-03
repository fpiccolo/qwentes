<?php
declare(strict_types=1);

/** @var App $app*/

use App\Infrastructure\Controller\LoginController;
use App\Infrastructure\Middleware\HeaderValidatorMiddleware;
use Slim\App;

$app->post('/login', LoginController::class);