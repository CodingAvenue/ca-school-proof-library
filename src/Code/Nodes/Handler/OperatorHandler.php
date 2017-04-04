<?php

namespace CodingAvenue\Proof\Code\Nodes\Handler;

use CodingAvenue\Proof\Code\Nodes\TokenStream;
use CodingAvenue\Proof\Code\Nodes\Token;
use CodingAvenue\Proof\Code\Nodes\Reader;

class OperatorHandler Implements HandlerInterface
{
    const OPERATOR_IDENTIFIER = ">";

    public function handle(Reader $reader, TokenStream $stream)
    {
        if (!($reader->getSubstr(1) == self::OPERATOR_IDENTIFIER)) {
            return false;
        }

        $previousToken = $stream->peekPreviousToken();

        if (is_null($previousToken)) {
            throw new \Exception("Operator cannot be used at the start of the selector");
        }

        if (!$previousToken->isWhiteSpace()) {
            throw new \Exception("Operator must have a space in between it.");
        }

        $reader->movePosition(1);
        $reader->skipWhiteSpace();

        $stream->push(new Token(Token::TYPE_OPERATOR, '>'));
        
        return true;
    }
}
