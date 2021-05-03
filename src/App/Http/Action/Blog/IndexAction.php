<?php

namespace App\Http\Action\Blog;

use App\ReadModel\Pagination;
use App\ReadModel\PostReadRepository;
use Framework\Template\TemplateRenderer;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
//use Zend\Diactoros\Response\HtmlResponse;
//use Zend\Diactoros\Response\JsonResponse;

class IndexAction
{
    private const PER_PAGE = 5;

    // private $posts;
    // private $template;

    public function __invoke()
    {
        return new JsonResponse([
            ['id' => 2, 'title' => 'The second post'],
            ['id' => 1, 'title' => 'The first post'],
        ]);
    }
}
