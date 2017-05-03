<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\SelectorParser\Transformer\ArrayTransformer;
use CodingAvenue\Proof\SelectorParser\TokenStream;


class ArrayTransformerTest extends TestCase
{
    protected static $transformer;

    public static function setUpBeforeClass()
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

        self::$transformer = new ArrayTransformer($stream);
    }

    public function testTransform()
    {
        $transformed = self::$transformer->transform();

        $this->assertEquals(true, array_key_exists('node', $transformed), "Node key exists");
        $this->assertEquals(true, array_key_exists('attribute', $transformed), "attribute key exists");
        $this->assertEquals('operator', $transformed['node'], "operator is the value of key node");
        $this->assertInternalType('array', $transformed['attribute'], 'attribute key has a value of array');
        $this->assertEquals('jerome', $transformed['attribute']['name'], 'The name attribute has a value of jerome');
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $stream = new TokenStream();
        $stream->push('string', 'o');
        $stream->push('string', 'p');
        $stream->push('string', 'e');
        $stream->push('whitespace', ' ');
        $stream->push('string', 'r');
        $stream->push('string', 'a');
        $stream->push('string', 't');
        $stream->push('string', 'o');
        $stream->push('string', 'r');

        $transformer = new ArrayTransformer($stream);

        $transformer->transform();
    }
}
