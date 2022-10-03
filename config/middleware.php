<?php
declare(strict_types=1);

/** @var \Slim\App $app */

use App\Infrastructure\Middleware\RequestMiddleware;


$app->add($container->get(RequestMiddleware::class));

$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setDefaultErrorHandler(
    $container->get('errorHandler')
);