<?php

namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class CredentialsMiddleware //implements MiddlewareInterface
{
    //public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    public function __invoke(ServerRequestInterface $request, callable $next)
    {
        // return $handler->handle($request)
        //     ->withHeader('X-Developer', 'ElisDN');
        /** @var \Psr\Http\Message\ResponseInterface $response */
        $response = $next($request);
        return $response->withHeader('X-Developer', 'Serj');
    }
}
