<?php

namespace App\Http\Action;

//use Psr\Http\Message\ResponseInterface as MessageResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;


class HelloAction
{
    //private $template;

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    //public function hand(ServerRequestInterface $request): ResponseInterface
    {
        //$this->template = $template;
        $name = $request->getQueryParams()['name'] ?? 'Guest';
        return new HtmlResponse('Hello, ' . $name . '!');
    }
    // public function process(ServerRequestInterface $request): ResponseInterface
    // {
    //     $name = $request->getQueryParams()['name'] ?? 'Guest';
    //     return new HtmlResponse('Hello, ' . $name . '!');
    // }
}
