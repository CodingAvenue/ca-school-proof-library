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
                    /**
                     * We need a way to stop transforming if it finds cascading selector which we don't support as of the moment.
                     * This way we inform the users that this isn't supported right now
                     * This is not an elegant solution right now, we need a better detection. Or better yet SUPPORT IT!
                     */
                    if (isset($transformed[$rule->getRuleType()])) {
                        throw new \Exception("Detecting multiple selector, we don't support multiple selector as of this time.");
                    }

                    $transformed[$rule->getRuleType()] = $rule->handle($this->stream);
                    continue 2;
                }                
            }
            
            throw new \Exception("No rules can handle this token {$startToken->getValue()}");
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