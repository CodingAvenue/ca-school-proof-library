<?php

namespace CodingAvenue\Proof\SelectorParser\Handler;

use CodingAvenue\Proof\SelectorParser\SourceReader;
use CodingAvenue\Proof\SelectorParser\TokenStream;

/**
 * The default handler for the parser. Creates a string token and push it to the TokenStream.
 */
class StringHandler implements HandlerInterface
{
    public function handle(SourceReader $reader, TokenStream $stream)
    {
        $char = $reader->getCurrentChar();
        $reader->movePosition(1);

        $stream->push($this->getType(), $char);

        return true;
    }

    public function getType()
    {
        return 'string';
    }
}