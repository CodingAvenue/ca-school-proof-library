<?php

namespace CodingAvenue\Proof\SelectorParser\Handler;

use CodingAvenue\Proof\SelectorParser\SourceReader;
use CodingAvenue\Proof\SelectorParser\TokenStream;

/**
 * The close square bracket character handler for the parser. Creates a close_square_bracket token and push it to the TokenStream.
 */
class CloseSquareBracketHandler implements HandlerInterface
{
    public function handle(SourceReader $reader, TokenStream $stream)
    {
        $char = $reader->getCurrentChar();
        if ($char !== ']') {
            return false;
        }

        $reader->movePosition(1);

        $stream->push($this->getType(), $char);

        return true;
    }

    public function getType()
    {
        return 'close_square_bracket';
    }
}
