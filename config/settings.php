<?php
declare(strict_types=1);

use App\Infrastructure\Console\CreateUserCommand;

define('APP_ROOT', __DIR__);

return [
    "settings" => [
        'displayErrorDetails' => true,
        'doctrine' => [
            // Enables or disables Doctrine metadata caching
            // for either performance or convenience during development.
            'dev_mode' => true,

            // Path where Doctrine will cache the processed metadata
            // when 'dev_mode' is false.
            'cache_dir' => APP_ROOT . '/../var/doctrine',

            // List of paths where Doctrine will search for metadata.
            // Metadata can be either YML/XML files or PHP classes annotated
            // with comments or PHP8 attributes.
            'metadata_dirs' => [APP_ROOT . '/../src/Domain/Entity'],

            'connection' => [
                'driver' => 'pdo_mysql',
                'host' => 'database',
                'port' => 3306,
                'dbname' => 'db',
                'user' => 'user',
                'password' => 'password',
                'charset' => 'utf8'
            ]
        ],
        'commands' => [
            CreateUserCommand::class
        ],
        'jwt' => [
            'key' => 'example_key',
            'algorithm' => 'HS256'
        ]
    ]
];