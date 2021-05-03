<?php

namespace Framework\config;

use App\Http\Middleware\BasicAuthMiddleware;
use Psr\Container\ContainerInterface;

return [
    'dependencies' => [
        'factories' => [
            BasicAuthMiddleware::class => function (ContainerInterface $container) {
                return new BasicAuthMiddleware($container->get('config')['users']);
            },
        ],
    ],
    'users' => [
        'admin' => 'password',
        ],
];
