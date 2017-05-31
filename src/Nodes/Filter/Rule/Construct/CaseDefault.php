<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Construct;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class CaseDefault extends Rule implements RuleInterface
{
    const CLASS_ = '\PhpParser\Node\Stmt\Case_';

    public function getRule(): callable
    {
        $class = self::CLASS_;

        return function($node) use ($class) {
            return ($node instanceof $class && is_null($node->cond));
        };
    }

    public function allowedOptionalFilter()
    {
        return array();
    }
}
