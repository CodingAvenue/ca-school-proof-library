<?php

namespace CodingAvenue\Proof\SelectorParser\Handler;

use CodingAvenue\Proof\SelectorParser\SourceReader;
use CodingAvenue\Proof\SelectorParser\TokenStream;

/**
 * The colon character handler for the parser. Creates a colon token and push it to the TokenStream.
 */
class ColonHandler implements HandlerInterface
{
    public function handle(SourceReader $reader, TokenStream $stream)
    {
        $char = $reader->getCurrentChar();
        if ($char !== ":") {
            return false;
        }

        $reader->movePosition(1);

        $stream->push($this->getType(), $char);

        return true;
    }

    public function getType()
    {
        return 'colon';
    }
}
