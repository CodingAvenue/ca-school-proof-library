<?php

namespace CodingAvenue\Proof\SelectorParser\Handler;

use CodingAvenue\Proof\SelectorParser\SourceReader;
use CodingAvenue\Proof\SelectorParser\TokenStream;

/**
 * The white space handler for the parser. Creates a whitespace token and push it to the TokenStream.
 */
class SpaceHandler implements HandlerInterface
{
    public function handle(SourceReader $reader, TokenStream $stream)
    {
        $char = $reader->getCurrentChar();
        if (!$this->isWhiteSpace($char)) {
            return false;
        }

        $reader->movePosition(1);

        $stream->push($this->getType(), $char);

        return true;
    }

    public function getType()
    {
        return 'whitespace';
    }

    public function isWhiteSpace(string $char)
    {
        return ($char == ' ' || $char == '\t' || $char == '\n' || $char == '\r');
    }
}
