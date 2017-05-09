<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Bitwise;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class ShiftLeft extends Rule implements RuleInterface
{
    const CLASS_ = '\PhpParser\Node\Expr\BinaryOp\ShiftLeft';

    public function getRule(): callable
    {
        $class = self::CLASS_;
        
        return function($node) use ($class) {
            return $node instanceof $class;
        };
    }

    public function allowedOptionalFilter()
    {
        return array();
    }
}
