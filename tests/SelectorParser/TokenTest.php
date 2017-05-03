<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\SelectorParser\Token;

class TokenTest extends TestCase
{
    public function testString()
    {
        $token = new Token("string", "c");

        $this->assertEquals("string", $token->getType(), "Type is a string token");
        $this->assertEquals("c", $token->getValue(), "Value is 'c'");
    }

    public function testOpenSquareBracket()
    {
        $token = new Token("open_square_bracket", "[");

        $this->assertEquals("open_square_bracket", $token->getType(), "Type is an open_square_bracket");
        $this->assertEquals("[", $token->getValue(), "Value is '['");
    }

    public function testCloseSquareBracket()
    {
        $token = new Token("close_square_bracket", "]");

        $this->assertEquals("close_square_bracket", $token->getType(), "Type is a close_square_bracket");
        $this->assertEquals("]", $token->getValue(), "Value is ']'");
    }

    public function testEqual()
    {
        $token = new Token("equal", "=");

        $this->assertEquals("equal", $token->getType(), "Type is an equal");
        $this->assertEquals("=", $token->getValue(), "Value is '='");
    }

    public function testQuote()
    {
        $token = new Token("quote", "'");

        $this->assertEquals("quote", $token->getType(), "Type is an '");
        $this->assertEquals("'", $token->getValue(), "Value is '");
    }
}
