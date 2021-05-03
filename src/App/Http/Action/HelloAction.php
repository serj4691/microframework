<?php

namespace App\Http\Action;

use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;


class HelloAction
{
    private $template;

    public function __construct(TemplateRenderer $template)
    {
        $this->template = $template;
    }

    //public function __invoke(ServerRequestInterface $request): ResponseInterface
    //public function hand(ServerRequestInterface $request): ResponseInterface
    public function __invoke()
    {
        //$this->template = $template;
        //$name = $request->getQueryParams()['name'] ?? 'Guest';
        //return new HtmlResponse('Hello, ' . htmlspecialchars($name, ENT_QUOTES || ENT_SUBSTITUTE) . '!');

//        $html = $this->render($name);
//        return  new \Laminas\Diactoros\Response\HtmlResponse($html);
//        return  new HtmlResponse($this->template->render('hello', [
//            'name' => $name,
//        ]));
        return  new HtmlResponse($this->template->render('app/hello'));
    }
    // public function process(ServerRequestInterface $request): ResponseInterface
    // {
    //     $name = $request->getQueryParams()['name'] ?? 'Guest';
    //     return new HtmlResponse('Hello, ' . $name . '!');
    // }

//    private function render($view, array $params = []): string
//    {
////        foreach ($params as $param => $value) {
////            ${$param} = $value;
////        }
//        $templateFile = 'templates/' . $view . '.php';
//        extract($params, EXTR_OVERWRITE);
//        ob_start();
//        require $templateFile;
//        return ob_get_clean();
//    }
}
