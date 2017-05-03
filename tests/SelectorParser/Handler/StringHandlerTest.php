<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\SelectorParser\SourceReader;
use CodingAvenue\Proof\SelectorParser\TokenStream;
use CodingAvenue\Proof\SelectorParser\Handler\StringHandler;

class StringHandlerTest extends TestCase
{
    protected static $handler;

    public static function setUpBeforeClass()
    {
        self::$handler = new StringHandler();
    }

    public function testGetType()
    {
        $this->assertEquals('string', self::$handler->getType(), "Type is string");
    }

    public function testCanHandle()
    {
        $this->assertEquals(true, self::$handler->handle(new SourceReader("d"), new TokenStream()), "Can handle the reader current position");
    }

    
}