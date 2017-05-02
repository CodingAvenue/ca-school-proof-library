<?php

namespace CodingAvenue\Proof\SelectorParser\Rule;

use CodingAvenue\Proof\SelectorParser\Token;
use CodingAvenue\Proof\SelectorParser\TokenStream;
use CodingAvenue\Proof\SelectorParser\Rule\RuleInterface;

class AttributeRule implements RuleInterface
{
    public function startToken(Token $token)
    {
        return $token->getType() === 'open_square_bracket';
    }

    public function endToken(Token $token)
    {
        return $token->getType() === 'close_square_bracket';
    }

    public function unexpectedToken(Token $token)
    {
        return false;
    }

    public function getRuleType()
    {
        return 'attribute';
    }

    public function handle(TokenStream $stream)
    {
        $token = $stream->getCurrentToken(); // Get the current cursor token and check if it satisfy this rule.

        if (!$this->startToken($token)) {
            throw new \Exception("Unsatisfied startToken rule detected. Current stream cursor is at token {$token->getValue()}");
        }

        $token = $stream->getNextToken(); //We move the cursor to the next Token ignoring the open bracket since we don't want that on the result

        $attributeValue = '';
        $attribute = array();

        while(!$stream->isEnd()) {
            $token = $stream->getCurrentToken();
            if ($this->endToken($token)) {
                break;
            }

            if ($token->getType() === 'whitespace') {
                // Skip whitespace characters inside the attribute strings.
                $token = $stream->getNextToken();
                continue;
            }
            $attributeValue .= $token->getValue();            
            $token = $stream->getNextToken();
        }

        //Check if the current Token satisfy the endToken()
        if (!$this->endToken($token)) {
            throw new \Exception("Expecting an close_square_bracket_token before the end of the stream");
        }

        $token = $stream->getNextToken(); // Move the stream cursor one more time since we don't want the next rule to check the closing bracket

        $attrs = explode(",", $attributeValue);
        foreach ($attrs as $attr) {
            list($key, $value) = explode("=", $attr);

            $attrValue = preg_replace('/^(\'(.*)\'|"(.*)")$/', '$2$3', $value); // Remove the single and double quote character at the start and end of the string.

            $attribute[$key] = $attrValue;
        }

        return $attribute;
    }
}
