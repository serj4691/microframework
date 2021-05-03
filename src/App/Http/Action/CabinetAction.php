<?php

namespace App\Http\Action;

use App\Http\Middleware\BasicAuthMiddleware;
use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\HtmlResponse;

class CabinetAction //implements RequestHandlerInterface
{
    private $template;
    private $users;

     public function __construct(TemplateRenderer $template)
     {
         $this->template = $template;
     }

    //public function handle(ServerRequestInterface $request): ResponseInterface
    public function __invoke(ServerRequestInterface $request)
    {
        //throw new \RuntimeException('Error!');
        $username = $request->getAttribute(BasicAuthMiddleware::ATTRIBUTE);

        //return new HtmlResponse('I am logged in as ' . $username);
         return new HtmlResponse($this->template->render('app/cabinet', [
             'name' => $username
         ]));

    }
}
