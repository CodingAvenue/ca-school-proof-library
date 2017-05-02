<?php

namespace CodingAvenue\Proof\SelectorParser\Transformer;

use CodingAvenue\Proof\SelectorParser\Transformer\TransformerInterface;
use CodingAvenue\Proof\SelectorParser\TokenStream;
use CodingAvenue\Proof\SelectorParser\Rule\RuleInterface;
use CodingAvenue\Proof\SelectorParser\Rule\NodeRule;
use CodingAvenue\Proof\SelectorParser\Rule\AttributeRule;

class ArrayTransformer implements TransformerInterface
{
    private $stream;
    private $rules;

    public function __construct(TokenStream $stream)
    {
        $this->stream = $stream;
        $this->addDefaultRules();
    }

    public function addDefaultRules()
    {
        $this->addRule(new NodeRule());
        $this->addRule(new AttributeRule());
    }

    public function addRule(RuleInterface $rule)
    {
        $this->rules[] = $rule;
    }

    public function transform(): array
    {
        $transformed = array();
        while (!$this->stream->isEnd()) {
            $startToken = $this->stream->getCurrentToken();

            foreach ($this->rules as $rule) {
                if ($rule->startToken($startToken)) {
                    $transformed[$rule->getRuleType()] = $rule->handle($this->stream);
                    continue 2;
                }
                
            }
        }

        return $transformed;
    }

    public function getNextToken()
    {
        return $this->stream->getNextToken();
    }

    public function start()
    {
        $token = $this->getNextToken();
        $this->_status = self::TRANSFORM_BEGIN;
        
        if ($token->getType() === 'open_square_bracket') {
            throw new \Exception("New Error");
        }

    }

    public function startToken(Token $token): boolean
    {
        if ($token === 'quote' || $token === 'open_square_bracket' || $token === 'close_square_bracket') {
            return false;
        }

        return true;
    }
}


/**
 * StreamTransformer Interface
 * 
 */