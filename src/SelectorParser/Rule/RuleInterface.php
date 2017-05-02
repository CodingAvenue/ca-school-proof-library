<?php

namespace CodingAvenue\Proof\SelectorParser\Rule;

use CodingAvenue\Proof\SelectorParser\Token;
use CodingAvenue\Proof\SelectorParser\TokenStream;

interface RuleInterface
{
    public function startToken(Token $token);

    public function endToken(Token $token);

    public function unexpectedToken(Token $token);

    public function handle(TokenStream $token); 

    public function getRuleType();  
}
