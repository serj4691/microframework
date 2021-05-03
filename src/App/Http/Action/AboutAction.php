<?php

namespace App\Http\Action;

//use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;

class AboutAction
{
    //private $template;

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        //$this->template = $template;
        return new HtmlResponse('I am a simple site');
    }
}
