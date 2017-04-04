<?php

namespace CodingAvenue\Proof\Code\Nodes\Handler;

use CodingAvenue\Proof\Code\Nodes\TokenStream;
use CodingAvenue\Proof\Code\Nodes\Token;
use CodingAvenue\Proof\Code\Nodes\Reader;

class PseudoClassHandler implements HandlerInterface
{
    const IDENTIFIER = ':';

    public function handle(Reader $reader, TokenStream $stream)
    {
        if ($reader->getSubstr(1) != self::IDENTIFIER) {
            return false;
        }

        $reader->movePosition(1);

        $pseudoType = '';
        while (!$reader->isEnd() && !$reader->isWhiteSpace()) {
            $pseudoType .= $reader->getSubstr(1);
            $reader->movePosition(1);
        }

        if ($pseudoType == '') {
            throw new \Exception("Pseudo identifier must be followed by a pseudo class");
        }

        $stream->push(new Token(Token::TYPE_PSEUDO, $pseudoType));

        return true;
    }
}
