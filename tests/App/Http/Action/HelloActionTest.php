<?php

namespace Test\App\Http\Action;

use App\Http\Action\HelloAction;
use Framework\Template\TemplateRenderer;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;
use Psr\Http\Message;
use Zend\Diactoros\Response;

class HelloActionTest extends TestCase
{
    private $renderer;

    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->renderer = new TemplateRenderer('templates');
    }

    public function test()
    {
        $action = new HelloAction($this->renderer);
        //$request = new ServerRequest();
        $response = $action();

        self::assertEquals(200, $response->getStatusCode());
        self::assertContains('Hello!', $response->getBody()->getContents());
    }

//    public function testJson()
//    {
//        $action = new HelloAction($this->renderer);
//        $request = (new ServerRequest())
//            ->withQueryParams(['name' => 'John']);
//        $response = $action($request);
//
//        self::assertContains('Hello, John !', $response->getBody()->getContents());
//    }
}
