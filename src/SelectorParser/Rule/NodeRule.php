<?php

namespace CodingAvenue\Proof\SelectorParser\Rule;

use CodingAvenue\Proof\SelectorParser\Token;
use CodingAvenue\Proof\SelectorParser\TokenStream;
use CodingAvenue\Proof\SelectorParser\Rule\RuleInterface;

class NodeRule implements RuleInterface
{
    public function startToken(Token $token)
    {
        return $token->getType() === 'string';
    }

    public function endToken(Token $token)
    {
        return $token->getType() === 'open_square_bracket' || $token->getType() === 'whitespace';
    }

    public function unexpectedToken(Token $token)
    {
        return $token->getType() === 'close_square_bracket' || $token->getType() === 'comma' || $token->getType() === 'equal';
    }

    public function getRuleType()
    {
        return 'node';
    }

    public function handle(TokenStream $stream)
    {
        $token = $stream->getCurrentToken(); // Get the current cursor token and check if it satisfy this rule.

        if (!$this->startToken($token)) {
            throw new \Exception("Unsatisfied startToken rule detected. Current stream cursor is at token {$token->getValue()}");
        }

        // If we're here it means we're handling the stream until we satisfy the endToken() method

        $node = '';
        while(!$stream->isEnd()) {
            $token = $stream->getCurrentToken();
            if ($this->unexpectedToken($token)) {
                throw new \Exception("Unexpected token {$token->getValue()}");
            }

            if ($this->endToken($token)) {
                break;
            }

            $node .= $token->getValue();
            $token = $stream->getNextToken();
        }

        return $node;
    }
}