<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\SelectorParser\SourceReader;

class SourceReaderTest extends TestCase
{
    protected static $reader;

    public static function setUpBeforeClass()
    {
        self::$reader = new SourceReader("Operator");
    }

    public function testInstanceOf()
    {
        $this->assertInstanceOf(SourceReader::class, self::$reader, "\$reader is an instance of SourceReader class");
    }

    public function testSource()
    {
        $this->assertEquals("Operator", self::$reader->getSource(), "Source Reader source attribute is the same string we pass on the constructor");
    }

    public function testLength()
    {
        $this->assertEquals(8, self::$reader->getLength(), "Source length is 8 characters");
    }

    public function testPosition()
    {
        $this->assertEquals(0, self::$reader->getPosition(), "Source position is at 0");
    }

    public function testGetCurrentChar()
    {
        $this->assertEquals("O", self::$reader->getCurrentChar(), "Current position character is 'O'");
    }

    public function testGetNextChar()
    {
        self::$reader->movePosition(1);
        $this->assertEquals("p", self::$reader->getCurrentChar(), "Next character is 'p'");
    }

    public function testRemainingLength()
    {
        $this->assertEquals(7, self::$reader->getRemainingLength(), "7 more characters remaining from the current position");
    }

    public function testIsWhiteSpace()
    {
        $this->assertEquals(false, self::$reader->isWhiteSpace(), "The current character is not a white space");
    }
}
