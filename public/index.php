<?php

use Laminas\Diactoros\ServerRequestFactory;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Framework\Http\Application;
use Laminas\Diactoros\Response;

/**
 *@var \Psr\Container\ContainerInterface $container
 *@var \Framework\Http\Application $app
 */
chdir(dirname(__DIR__));
require 'vendor/autoload.php';

### Configuration
$container = require 'config/container.php';
### Initialization
$app = $container->get(Application::class);
require 'config/pipeline.php';
require 'config/routes.php';
### Running
$request = ServerRequestFactory::fromGlobals();
$response = $app->run($request, new Response());
### Sending
$emitter = new SapiEmitter();
$emitter->emit($response);
