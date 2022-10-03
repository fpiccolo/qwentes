<?php
declare(strict_types=1);

use DI\Container;
use Slim\Factory\AppFactory;

$settings = require __DIR__ . '/settings.php';

$container = new Container();

$container->set('settings', $settings['settings']);

AppFactory::setContainer($container);

$app = AppFactory::create();

require __DIR__ . '/dependencies.php';
require __DIR__ . '/routes.php';
require __DIR__ . '/middleware.php';

return $app;