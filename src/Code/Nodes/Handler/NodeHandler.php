<?php

namespace CodingAvenue\Proof\Code\Nodes\Handler;

use CodingAvenue\Proof\Code\Nodes\TokenStream;
use CodingAvenue\Proof\Code\Nodes\Token;
use CodingAvenue\Proof\Code\Nodes\Reader;

class NodeHandler Implements HandlerInterface
{
    const NODE_TYPE_PATTERN = '/[a-zA-Z]/';

    public function handle(Reader $reader, TokenStream $stream)
    {
        // Let's check first if this handler can really handle it. Return immediately if it cannot.'
        if(!preg_match(self::NODE_TYPE_PATTERN, $reader->getSubstr(1))) {
            return false;
        }

        $nodeType = '';
        while (!$reader->isEnd()) {
            if (preg_match(self::NODE_TYPE_PATTERN, $reader->getSubstr(1))) {
                $nodeType .= $reader->getSubstr(1);
                $reader->movePosition(1);
                continue;
            }

            break;
        }

        $stream->push(new Token(Token::TYPE_NODE, $nodeType));

        return true;
    }
}
