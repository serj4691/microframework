<?php

namespace Framework\Http\Pipeline;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\ServerRequest;
use App\Http\Middleware\ProfilerMiddleware;

class Next
{
    private $next;
    private $queue;
    private $response;

    public  function __construct(\SplQueue $queue, callable $next)
    {
        $this->next = $next;
        $this->queue = $queue;
        //$this->response = $response;
    }
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        if ($this->queue->isEmpty()) {
            return ($this->next)($request, $response);
        }
        $middleware = $this->queue->dequeue();
        return $middleware($request, $response, function (ServerRequestInterface $request) use ($response) {
            return $this($request, $response);
        });
    }
}
