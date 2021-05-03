<?php

namespace tests\Framework\Http;

use Framework\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    // protected function setUp(): void
    // {
    //     parent::setUp();
    //     $_GET = [];
    //     $_POST = [];
    // }

    public function testEmpty(): void
    {
        $request = new Request();

        self::assertEquals([], $request->getQueryParams());
        self::assertNull($request->getParsedBody());
    }

    public function testQueryParams(): void
    {
        $request = (new Request())
            ->withQueryParams($data = [
                'name' => 'John',
                'age' => 28
            ]);

        self::assertEquals($data, $request->getQueryParams());
        self::assertNull($request->getParsedBody());
    }

    public function testParsedBody(): void
    {
        $request = (new Request())
            ->withParsedBody($data = ['title' => 'Title']);;

        self::assertEquals([], $request->getQueryParams());
        self::assertNull($data, $request->getParsedBody());
    }
}
