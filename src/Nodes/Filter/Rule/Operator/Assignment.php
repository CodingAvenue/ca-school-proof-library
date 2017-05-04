<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Operator;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Assignment extends Rule implements RuleInterface
{
    const CLASS_ = '\PhpParser\Node\Expr\Assign';

    public function getRule(): callable
    {
        $class = self::CLASS_;
        $filter = $this->filter;
        
        return function($node) use ($class, $filter) {
            if (isset($filter['variable'])) {
                return ($node instanceof $class && $node->var->name === $filter['variable']);
            }

            return $node instanceof $class;
        };
    }

    public function allowedOptionalFilter()
    {
        return array('variable');
    }
}
