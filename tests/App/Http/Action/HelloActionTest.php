<?php

namespace Test\App\Http\Action;

use App\Http\Action\HelloAction;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;
use Psr\Http\Message;
use Zend\Diactoros\Response;

class HelloActionTest extends TestCase
{
    public function testGuest()
    {
        $action = new HelloAction();
        $request = new ServerRequest();
        $response = $action($request);

        //self::assertEquals(200, $response->getStatusC);
        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals('Hello, Guest!', $response->getBody()->getContents());
    }

    public function testJson()
    {
        $action = new HelloAction();
        $request = (new ServerRequest())
            ->withQueryParams(['name' => 'John']);
        $response = $action($request);

        self::assertEquals('Hello, John!', $response->getBody()->getContents());
    }
}
