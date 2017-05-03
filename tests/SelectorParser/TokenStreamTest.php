<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\SelectorParser\TokenStream;
use CodingAvenue\Proof\SelectorParser\Token;

class TokenStreamTest extends TestCase
{
    protected static $stream;

    public static function setUpBeforeClass()
    {
        self::$stream = new TokenStream();
    }

    public function testInstance()
    {
        $this->assertInstanceOf(TokenStream::class, self::$stream, "Stream is an instance of the TokenStream class");  
    }

    public function testGetCursor()
    {
        $this->assertEquals(0, self::$stream->getCursor(), "The stream cursor start at 0");
    }

    public function testPush()
    {
        self::$stream->push("string", "z");
        $this->assertEquals(1, self::$stream->getLength(), "Length of the stream is now 1 after we push");
    }

    public function testHasTokens()
    {
        $this->assertEquals(true, self::$stream->hasTokens(), "stream now has tokens");
    }

    public function testGetCurrentToken()
    {
        self::$stream->push("string", "a");

        $this->assertInstanceOf(Token::class, self::$stream->getCurrentToken(), "getCurrentToken return an instance of the Token class");
    }

    public function testGetRemainingLength()
    {
        $this->assertEquals(2, self::$stream->getRemainingLength(), "RemainingLength is still on 2");
    }
    
    public function testPeekNextToken()
    {
        $token = self::$stream->peekNextToken();

        $this->assertInstanceOf(Token::class, $token, "peekNextToken gives us an instance of the Token class");
        $this->assertEquals(0, self::$stream->getCursor(), "The cursor is still at position 0");
        $this->assertEquals(2, self::$stream->getRemainingLength(), "The remaining length is still at 2");
    }

    public function testGetNextToken()
    {
        $token = self::$stream->getNextToken();

        $this->assertInstanceOf(Token::class, $token, "getNextToken gives us an instance of the Token class");
        $this->assertEquals(1, self::$stream->getCursor(), "The cursor is now at position 1");
        $this->assertEquals(1, self::$stream->getRemainingLength(), "The remaining length is now 1");
    }
}
