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

    // public function __construct(TemplateRenderer $template)
    // {
    //     $this->template = $template;
    // }
    // public function __construct(array $users)
    // {
    //     $this->users = $users;
    // }
    //public function handle(ServerRequestInterface $request): ResponseInterface
    public function __invoke(ServerRequestInterface $request)
    {
        //throw new \RuntimeException('Error!');
        $username = $request->getAttribute(BasicAuthMiddleware::ATTRIBUTE);

        return new HtmlResponse('I am logged in as ' . $username);
        // return new HtmlResponse($this->template->render('app/cabinet', [
        //     'name' => $username
        // ]));
        // $username = $_SERVER['PHP_AUTH_USER'] ?? null;
        // $password = $_SERVER['PHPAUTH_PW'] ?? null;
        // $username = $request->getServerParams()['PHP_AUTH_USER'] ?? null;
        // $password = $request->getServerParams()['PHP_AUTH_PW'] ?? null;

        // if (!empty($username)  && !empty($password)) {
        //     foreach ($this->users as $name => $pass) {
        //         if ($username === $name && $pssword === $pass) {
        //             return new HtmlResponse('I am logged in as ' . $username);
        //         }
        //     }
        // }
        // return new EmptyResponse(401, ['WWW-Authenticate' => 'Basic realm=Resrticted area']);

    }
}
