<?php

namespace CodingAvenue\Proof\Code\Nodes\Handler;

use CodingAvenue\Proof\Code\Nodes\TokenStream;
use CodingAvenue\Proof\Code\Nodes\Token;
use CodingAvenue\Proof\Code\Nodes\Reader;

class WhiteSpaceHandler Implements HandlerInterface
{
    public function handle(Reader $reader, TokenStream $stream)
    {
        if (!$reader->isWhiteSpace()) {
            return false;
        }

        $reader->skipWhiteSpace();

        $stream->push(new Token(Token::TYPE_WHITESPACE, ''));
        
        return true;
    }
}
