<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\SelectorParser\SourceReader;
use CodingAvenue\Proof\SelectorParser\TokenStream;
use CodingAvenue\Proof\SelectorParser\Handler\QuoteHandler;

class QuoteHandlerTest extends TestCase
{
    protected static $handler;

    public static function setUpBeforeClass()
    {
        self::$handler = new QuoteHandler();
    }

    public function testGetType()
    {
        $this->assertEquals('quote', self::$handler->getType(), "Type is quote");
    }

    public function testCanHandle()
    {
        $this->assertEquals(true, self::$handler->handle(new SourceReader("'"), new TokenStream()), "Can handle the reader current position");
        $this->assertEquals(true, self::$handler->handle(new SourceReader('"'), new TokenStream()), "Can handle the reader current position");
    }

    public function testCannotHandle()
    {
        $this->assertEquals(false, self::$handler->handle(new SourceReader("d"), new TokenStream()), "Cannot handle the reader current position");
    }
}