<?php

namespace Framework\Http\Pipeline;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Pipeline
{
    private $queue;

    public function __construct()
    {
        $this->queue = new \SplQueue();
    }
    public function pipe($middleware): void
    {
        $this->queue->enqueue($middleware);
    }
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
    {
        //return $this->next($request, $default);
        $delegate = new Next(clone $this->queue, $next);
        return $delegate($request, $response);
    }
    // private function next(ServerRequestInterface $request, callable $default): ResponseInterface
    // {
    //     if ($this->queue->isEmpty()) {
    //         return $default($request);
    //     }
    //     $current = $this->queue->dequeue();

    //     return $current($request, function (ServerRequestInterface $request) use ($default) {
    //         return $this->next($request, $default);
    //     });
    // }
}
