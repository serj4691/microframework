<?php

namespace Test\Framework\Http\Pipeline;

use Framework\Http\Application;
use Framework\Http\Pipeline\MiddlewareResolver;
use Framework\Http\Router\Router;
use Laminas\Diactoros\Response;
use PHPUnit\Framework\TestCase;
use Framework\Http\Pipeline\Pipeline;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
//use Zend\Diactoros\Response\JsonResponse;
//use Zend\Diactoros\ServerRequest;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Response\JsonResponse;
use Tests\Framework\Http\DummyContainer;

class ApplicationTest extends TestCase
{
    /**
     *@var MiddlewareResolver
     */
    private $resolver;
    /**
     *@var Router
     */
    private $router;

    public function setup()
    {
        parent::setup();
        $this->resolver = new MiddlewareResolver(new DummyContainer());
        $this->router = $this->createMock(Router::class);
    }
    public function testPipe()
    {
        $app = new Application($this->resolver, $this->router, new DefaultHandler(), new Response());

        $app->pipe(new Middleware1());
        $app->pipe(new Middleware2());
        $response = $app->run(new ServerRequest(), new Response());
        $this->assertJsonStringEqualsJsonString(
            json_encode(['middleware-1' => 1, 'middleware-2' => 2]),
            $response->getBody()->getContents()
        );
    }
}
class Middleware1
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        return $next($request->withAttribute('middleware-1', 1));
    }
}
class Middleware2
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        return $next($request->withAttribute('middleware-2', 2));
    }
}
class DefaultHandler
{
    public function __invoke(ServerRequestinterface $request)
    {
        return new JsonResponse($request->getAttributes());
    }
}
