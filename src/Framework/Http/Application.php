<?php

namespace Framework\Http;

use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\RouteData;
use Framework\Http\Router\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
//use Zend\Stratigility\Middleware\PathMiddlewareDecorator;
//use Zend\Stratigility\MiddlewarePipe;
use Framework\Http\Pipeline\Pipeline;

use Laminas\Diactoros\Response;
use Laminas\Diactoros\ResponseFactory;
use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Laminas\HttpHandlerRunner\RequestHandlerRunner;
use Laminas\Stratigility\Middleware\NotFoundHandler;
use Laminas\Stratigility\MiddlewarePipe;

use function Laminas\Stratigility\middleware;
use function Laminas\Stratigility\path;


class Application extends MiddlewarePipe//, RequestHandlerInterface
{
    private $resolver;
    private $router;
    private $default;
    // private $pipeline;

    public function __construct(MiddlewareResolver $resolver, Router $router, callable $default, ResponseInterface $responsePrototype)
    {
        parent::__construct();
        $this->resolver = $resolver;
        $this->router = $router;
        // $this->pipeline = new MiddlewarePipe();
        $this->default = $default;
        $this->setResponsePrototype($responsePrototype);
    }

    public function pipe($path, $middleware = null): MiddlewarePipe
    {
        if ($middleware === null) {
            return parent::pipe($this->resolver->resolve($path, $this->responsePrototype));
        }
        return parent::pipe($path, $this->resolver->resolve($middleware, $this->responsePrototype));

        //parent::pipe($this->resolver->resolve($middleware));
    }

     private function route($name, $path, $handler, array $methods, array $options = []): void
     {
         $this->router->addRoute(new RouteData($name, $path, $handler, $methods, $options));
     }

     public function any($name, $path, $handler, array $options = []): void
     {
         $this->route($name, $path, $handler, $options);
     }

     public function get($name, $path, $handler, array $options = []): void
     {
         $this->route($name, $path, $handler, ['GET'], $options);
     }

     public function post($name, $path, $handler, array $options = []): void
     {
         $this->route($name, $path, $handler, ['POST'], $options);
     }

     public function put($name, $path, $handler, array $options = []): void
     {
         $this->route($name, $path, $handler, ['PUT'], $options);
     }

     public function patch($name, $path, $handler, array $options = []): void
     {
         $this->route($name, $path, $handler, ['PATCH'], $options);
     }

     public function delete($name, $path, $handler, array $options = []): void
     {
         $this->route($name, $path, $handler, ['DELETE'], $options);
     }

    // public function handle(ServerRequestInterface $request): ResponseInterface
    // {
    //     return $this->pipeline->process($request, $this->default);
    // }

//     public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
//     {
//         return $this->pipeline->process($request, $handler);
//     }

    public function run(ServerRequestInterface $request, ResponseInterface $response)
    {
        return $this($request, $response, $this->default);
    }
}
