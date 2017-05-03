<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\SelectorParser\Parser;
use CodingAvenue\Proof\SelectorParser\TokenStream;

class ParserTest extends TestCase
{
    public function testParser()
    {
        $parser = new Parser("operator");

        $this->assertInstanceOf(Parser::class, $parser, "\$parser is an instance of the Parser class");

        $stream = $parser->parse();

        $this->assertInstanceOf(TokenStream::class, $stream, "\$stream is an instance of the TokenStream class");

        $this->assertEquals(8, $stream->getLength(), "The length of the stream is 8");
    }
}
