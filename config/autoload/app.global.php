<?php

use App\Http\Middleware\ErrorHandleMiddleware;
use App\Http\Middleware\NotFoundHandler;
use Framework\Http\Application;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\AuraRouterAdapter;
use Framework\Http\Router\Router;
use Framework\Template\TemplateRenderer;
use Framework\Template\PhpRenderer;
use Laminas\Diactoros\Response;
use Psr\Container\ContainerInterface;

return [
    'dependencies' => [
        'abstract_factories' => [
            \Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory::class,
        ],
        'factories' => [
            Application::class => function (ContainerInterface $container) {
                return new Application(
                    $container->get(MiddlewareResolver::class),
                    $container->get(Router::class),
                    new NotFoundHandler(),
                    new Response()
                );
            },
            Router::class => function () {
                return new AuraRouterAdapter(new Aura\Router\RouterContainer());
            },
            MiddlewareResolver::class => function (ContainerInterface $container) {
                return new MiddlewareResolver($container);
            },
            ErrorHandleMiddleware::class => function (ContainerInterface $container) {
                return new ErrorHandleMiddleware($container->get('config')['debug']);
            },
            TemplateRenderer::class =>function () {
                return new PhpRenderer('templates');
            },
        ],
    ],
    'debug' => true,
];
