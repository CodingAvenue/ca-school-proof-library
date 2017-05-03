<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\SelectorParser\SourceReader;
use CodingAvenue\Proof\SelectorParser\TokenStream;
use CodingAvenue\Proof\SelectorParser\Handler\CommaHandler;

class CommaHandlerTest extends TestCase
{
    protected static $handler;

    public static function setUpBeforeClass()
    {
        self::$handler = new CommaHandler();
    }

    public function testGetType()
    {
        $this->assertEquals('comma', self::$handler->getType(), "Type is comma");
    }

    public function testCanHandle()
    {
        $this->assertEquals(true, self::$handler->handle(new SourceReader(","), new TokenStream()), "Can handle the reader current position");
    }

    public function testCannotHandle()
    {
        $this->assertEquals(false, self::$handler->handle(new SourceReader("d"), new TokenStream()), "Cannot handle the reader current position");
    }
}