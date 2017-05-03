<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\SelectorParser\Rule\AttributeRule;
use CodingAvenue\Proof\SelectorParser\Token;
use CodingAvenue\Proof\SelectorParser\TokenStream;

class AttributeRuleTest extends TestCase
{
    protected static $attribute;

    public static function setUpBeforeClass()
    {
        self::$attribute = new AttributeRule();
    }

    public function testStartToken()
    {
        $token = new Token('open_square_bracket', '[');
        $this->assertEquals(true, self::$attribute->startToken($token), "Token is the expected start token");

        $token = new Token('string', 's');
        $this->assertEquals(false, self::$attribute->startToken($token), "Token is not the expected start token");
    }

    public function testEndToken()
    {
        $token = new Token('close_square_bracket', ']');
        $this->assertEquals(true, self::$attribute->endToken($token), "Token is the expected end token");

        $token = new Token('string', 's');
        $this->assertEquals(false, self::$attribute->endToken($token), "Token is not the expected end token");
    }

    public function testUnexpectedToken()
    {
        $token = new Token('string', 'd');
        $this->assertEquals(false, self::$attribute->unexpectedToken($token), "Token is not an unexpected token");
    }

    public function testGetRuleType()
    {
        $this->assertEquals('attribute', self::$attribute->getRuleType(), 'Rule Type is attribute');
    }

    public function testHandle()
    {
        $stream = new TokenStream();

        $stream->push('open_square_bracket', '[');
        $stream->push('string', 'n');
        $stream->push('string', 'a');
        $stream->push('string', 'm');
        $stream->push('string', 'e');
        $stream->push('equal', '=');
        $stream->push('quote', '"');
        $stream->push('string', 'j');
        $stream->push('string', 'e');
        $stream->push('string', 'r');
        $stream->push('string', 'o');
        $stream->push('string', 'm');
        $stream->push('string', 'e');
        $stream->push('quote', '"');
        $stream->push('close_square_bracket', ']');

        $arrayAttribute = self::$attribute->handle($stream);

        $this->assertInternalType('array', $arrayAttribute, 'handle() returns an array');
        $this->assertEquals(true, array_key_exists("name", $arrayAttribute), "The key 'name' exists");
        $this->assertEquals('jerome', $arrayAttribute['name'], "The key 'name' has a value of 'jerome'");
    }

    public function testException()
    {
        $this->expectException(Exception::class);
        $stream = new TokenStream();

        $stream->push('string', 'n');
        $stream->push('string', 'a');
        $stream->push('string', 'm');

        $arrayAttribute = self::$attribute->handle($stream);
    }

    public function testAnotherException()
    {
        $this->expectException(Exception::class);

        $stream = new TokenStream();

        $stream->push('open_square_bracket', '[');
        $stream->push('string', 'n');
        $stream->push('string', 'a');
        $stream->push('string', 'm');
        $stream->push('string', 'e');
        $stream->push('equal', '=');
        $stream->push('quote', '"');
        $stream->push('string', 'j');
        $stream->push('string', 'e');
        $stream->push('string', 'r');
        $stream->push('string', 'o');
        $stream->push('string', 'm');
        $stream->push('string', 'e');
        $stream->push('quote', '"');

        $arrayAttribute = self::$attribute->handle($stream);
    }
}
