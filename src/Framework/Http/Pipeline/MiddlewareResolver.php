<?php

namespace Framework\Http\Pipeline;

use Psr\Container\ContainerInterface;
use Laminas\Stratigility\MiddlewarePipe;
//use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use ReflectionObject;
//use Zend\Stratigility\Middleware\DoublePassMiddlewareDecorator;
//use Zend\Stratigility\Middleware\RequestHandlerMiddleware;
//use Zend\Stratigility\MiddlewarePipe;
//use Laminas\Stratigility\MiddlewarePipe;
//use Framework\Http\Pipeline\UnknownMiddlewareTypeException;

class MiddlewareResolver
{
    private $container;
    //private $responsePrototype;

     public function __construct(ContainerInterface $container)
     {
         $this->container = $container;
         //$this->responsePrototype = $responsePrototype;
     }

    public function resolve($handler, ResponseInterface $responsePrototype): callable //MiddlewareInterface
    {
        if (\is_array($handler)) {
            return $this->createPipe($handler, $responsePrototype);
        }
        if (\is_string($handler) && $this->container->has($handler)) {
            return function (ServerRequestInterface $request, ResponseInterface $response, callable $next) use ($handler) {
                $middleware = $this->resolve($this->container->get($handler), $response);
                return $middleware($request, $response, $next);
            };
        }
        if ($handler instanceof MiddlewareInterface) {
            return function (ServerRequestInterface $request, ResponseInterface $response, callable $next) use ($handler) {
                return $handler->process($request, new InteropHandlerWrapper($next));
            };
        }

        if (\is_object($handler)) {
            $reflection = new ReflectionObject($handler);
            if ($reflection->hasMethod('__invoke')) {
                $method = $reflection->getMethod('__invoke');
                $parameters = $method->getParameters();
                if (\count($parameters) === 2 && $parameters[1]->isCallable()) {
                    //return new SinglePassMiddlewareDecorator($handler);
                    return function (ServerRequestInterface $request, ResponseInterface $response, callable $next) use ($handler) {
                        return $handler($request, $next);
                    };
                }
                //return new DoublePassMiddlewareDecorator($handler, $this->responsePrototype);
                return $handler;
            }
        }
        throw new UnknownMiddlewareTypeException($handler);

        //     if (\is_string($handler) && $this->container->has($handler)) {
        //         return new LazyMiddlewareDecorator($this, $this->container, $handler);
        //     }

        //     if ($handler instanceof MiddlewareInterface) {
        //         return $handler;
        //     }

        //     if ($handler instanceof RequestHandlerInterface) {
        //         return new RequestHandlerMiddleware($handler);
        //     }

        //     if (\is_object($handler)) {
        //         $reflection = new \ReflectionObject($handler);
        //         if ($reflection->hasMethod('__invoke')) {
        //             $method = $reflection->getMethod('__invoke');
        //             $parameters = $method->getParameters();
        //             if (\count($parameters) === 2 && $parameters[1]->isCallable()) {
        //                 return new SinglePassMiddlewareDecorator($handler);
        //             }
        //             return new DoublePassMiddlewareDecorator($handler, $this->responsePrototype);
        //         }
        //     }

        //     throw new UnknownMiddlewareTypeException($handler);
    }

    private function createPipe(array $handlers, $responsePrototype): MiddlewarePipe
    {
        $pipeline = new MiddlewarePipe();
        $pipeline->setResponsePrototype($responsePrototype);
        foreach ($handlers as $handler) {
            $pipeline->pipe($this->resolve($handler, $responsePrototype));
        }
        return $pipeline;
    }
}
