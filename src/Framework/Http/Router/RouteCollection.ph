<?php

namespace Framework\Http\Router;

use Framework\Http\Router\RegexpRoute;

class RouteCollection
{
    private $routes = [];

    public function addRoute(Route $route): void
    {
        $this->routes[] = $route;
    }

    public function add($name, $pattern, $handler, array $methods, array $tokens = []): void
    {
        $this->addRoute(new RegexpRoute($name, $pattern, $handler, $methods, $tokens));
    }

    public function any($name, $pattern, $handler, array $tokens = []): void
    {
        $this->addRoute(new RegexpRoute($name, $pattern, $handler, [], $tokens));
    }

    public function get($name, $pattern, $handler, array $tokens = []): void
    {
        $this->addRoute(new RegexpRoute($name, $pattern, $handler, ['GET'], $tokens));
    }

    public function post($name, $pattern, $handler, array $tokens = []): void
    {
        $this->addRoute(new RegexpRoute($name, $pattern, $handler, ['POST'], $tokens));
    }

    /**
     * @return Route[]
     */
    public function getRoutes(): array
    {
        return $this->routes;
    }
}
