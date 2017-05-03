<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\SelectorParser\SourceReader;
use CodingAvenue\Proof\SelectorParser\TokenStream;
use CodingAvenue\Proof\SelectorParser\Handler\SpaceHandler;

class SpaceHandlerTest extends TestCase
{
    protected static $handler;

    public static function setUpBeforeClass()
    {
        self::$handler = new SpaceHandler();
    }

    public function testGetType()
    {
        $this->assertEquals('whitespace', self::$handler->getType(), "Type is whitespace");
    }

    public function testCanHandle()
    {
        $this->assertEquals(true, self::$handler->handle(new SourceReader(" "), new TokenStream()), "Can handle the reader current position");
    }

    public function testCannotHandle()
    {
        $this->assertEquals(false, self::$handler->handle(new SourceReader("d"), new TokenStream()), "Cannot handle the reader current position");
    }
}