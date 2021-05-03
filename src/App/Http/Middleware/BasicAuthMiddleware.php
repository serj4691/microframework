<?php

namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class BasicAuthMiddleware //implements MiddlewareInterface
{
    public const ATTRIBUTE = '_user';

    private $users;
    //private $responsePrototype;

    public function __construct(array $users)
    {
        $this->users = $users;
        //$this->responsePrototype = $responsePrototype;
    }

    //public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        $username = $request->getServerParams()['PHP_AUTH_USER'] ?? null;
        $password = $request->getServerParams()['PHP_AUTH_PW'] ?? null;

        if (!empty($username) && !empty($password)) {
            foreach ($this->users as $name => $pass) {
                if ($username === $name && $password === $pass) {
                    return $next($request->withAttribute(self::ATTRIBUTE, $name));
                }
            }
        }

        return $response
            ->withStatus(401)
            ->withHeader('WWW-Authenticate', 'Basic realm=Restricted area');
        //return new EmptyResponse(401, ['WWW-Authenticate', 'Basic realm=Restricted area']);
    }
}
