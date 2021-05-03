<?php

namespace App\Http\Action\Blog;

use App\ReadModel\PostReadRepository;
use Framework\Template\TemplateRenderer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;

class ShowAction
{
    // private $posts;
    // private $template;

    public function __invoke(ServerRequestInterface $request, $next)
    {
        $id = $request->getAttribute('id');
        if ($id > 2) {
            return $next($request);
        }
        return new JsonResponse(['id' => $id, 'title' => 'Post #' . $id]);
    }
}
