<?php
declare(strict_types=1);

use Symfony\Component\Console\Application;

require_once __DIR__ . '/../vendor/autoload.php';
/** @var \Slim\App $app */
$app = require __DIR__ . '/../config/app.php';
$settings = $app->getContainer()->get('settings');


$application = new Application();

foreach ($settings['commands'] as $command){
    $application->add($app->getContainer()->get($command));
}

$application->run();