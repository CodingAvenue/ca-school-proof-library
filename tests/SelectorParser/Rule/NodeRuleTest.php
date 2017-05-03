<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\SelectorParser\Rule\NodeRule;
use CodingAvenue\Proof\SelectorParser\Token;
use CodingAvenue\Proof\SelectorParser\TokenStream;

class NodeRuleTest extends TestCase
{
    protected static $node;

    public static function setUpBeforeClass()
    {
        self::$node = new NodeRule();
    }

    public function testStartToken()
    {
        $token = new Token('string', 'a');
        $this->assertEquals(true, self::$node->startToken($token), "Token is the expected start token");

        $token = new Token('open_square_bracket', '[');
        $this->assertEquals(false, self::$node->startToken($token), "Token is not the expected start token");
    }

    public function testEndToken()
    {
        $token = new Token('open_square_bracket', '[');
        $this->assertEquals(true, self::$node->endToken($token), "Token is the expected end token");

        $token = new Token('string', 's');
        $this->assertEquals(false, self::$node->endToken($token), "Token is not the expected end token");
    }

    public function testUnexpectedToken()
    {
        $token = new Token('close_square_bracket', ']');
        $this->assertEquals(true, self::$node->unexpectedToken($token), "Token is an unexpected token");

        $token = new Token('comma', ',');
        $this->assertEquals(true, self::$node->unexpectedToken($token), "Token is an unexpected token");

        $token = new Token('equal', '=');
        $this->assertEquals(true, self::$node->unexpectedToken($token), "Token is an unexpected token");

        $token = new Token('string', 'a');
        $this->assertEquals(false, self::$node->unexpectedToken($token), "Token is not an unexpected token");
    }

    public function testGetRuleType()
    {
        $this->assertEquals("node", self::$node->getRuleType(), "Node is the Rule Type");
    }

    public function testHandle()
    {
        $stream = new TokenStream();

        $stream->push('string', 'o');
        $stream->push('string', 'p');
        $stream->push('string', 'e');
        $stream->push('string', 'r');
        $stream->push('string', 'a');
        $stream->push('string', 't');
        $stream->push('string', 'o');
        $stream->push('string', 'r');

        $node = self::$node->handle($stream);

        $this->assertEquals("operator", $node, "Handle returns a string");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $stream = new TokenStream();

        $stream->push('string', 'o');
        $stream->push('string', 'p');
        $stream->push('close_square_bracket', ']');
        $stream->push('string', 'e');

        $node = self::$node->handle($stream);
    }
}
