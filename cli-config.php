<?php
declare(strict_types=1);


use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Slim\App;

/** @var App $app */
$app = require_once __DIR__ . '/config/app.php';

return ConsoleRunner::createHelperSet($app->getContainer()->get(EntityManager::class));