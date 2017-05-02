<?php

namespace CodingAvenue\Proof\SelectorParser\Transformer;

use CodingAvenue\Proof\SelectorParser\Rule\RuleInterface;

interface TransformerInterface
{
    public function transform();

    public function addRule(RuleInterface $rule);
}
