<?php

namespace CodingAvenue\Proof\SelectorParser\Handler;

use CodingAvenue\Proof\SelectorParser\SourceReader;
use CodingAvenue\Proof\SelectorParser\TokenStream;

/**
 * The quote character handler for the parser. Creates a quote token and push it to the TokenStream.
 */
class QuoteHandler implements HandlerInterface
{
    public function handle(SourceReader $reader, TokenStream $stream)
    {
        $char = $reader->getCurrentChar();
        if (!$this->isQuote($char)) {
            return false;
        }

        $reader->movePosition(1);

        $stream->push($this->getType(), $char);

        return true;
    }

    public function getType()
    {
        return 'quote';
    }

    public function isQuote(string $char)
    {
        return $char === '"' || $char === "'";
    }
}
