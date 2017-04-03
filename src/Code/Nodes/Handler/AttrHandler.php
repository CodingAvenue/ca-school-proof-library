<?php

namespace CodingAvenue\Proof\Code\Nodes\Handler;

use CodingAvenue\Proof\Code\Nodes\TokenStream;
use CodingAvenue\Proof\Code\Nodes\Token;
use CodingAvenue\Proof\Code\Nodes\Reader;

class AttrHandler implements HandlerInterface
{
    const START_IDENTIFIER = '[';
    const END_IDENTIFIER = ']';

    public function handle(Reader $reader, TokenStream $stream)
    {
        // Let's check first if this handler can really handle it. Return immediately if it cannot.'
        if ($reader->getSubstr(1) != self::START_IDENTIFIER) {
            return false;
        }

        $reader->movePosition(1);

        $nodeAttr = '';
        while (!$reader->isEnd()) {
            if ($reader->getSubstr(1) != self::END_IDENTIFIER) {
                $nodeAttr .= $reader->getSubstr(1);
                $reader->movePosition(1);

                continue;
            }

            break;
        }

        // Check if we really really encountered an end identifier
        if ($reader->getSubstr(1) != self::END_IDENTIFIER) {
            throw new \Exception("Terminating Attribute identifier not found.");
        }

        $attrs = explode(",", $nodeAttr);
        $attrToken = [];
        foreach ($attrs as $attr) {
            list($attrName, $attrValue) = explode("=", $attr);

            $attrValue = preg_replace('/^(\'(.*)\'|"(.*)")$/', '$2$3', $attrValue); // Remove the single and double quote character at the start and end of the string.
            $attrToken[$attrName] = $attrValue;
        }

        $reader->movePosition(1); // Move the reader position by 1 since the current position is the attribute end identifier.

        $stream->push(new Token(Token::TYPE_ATTR, $attrToken));
        return true;
    }
}
