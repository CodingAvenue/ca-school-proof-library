<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Class_;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class MethodCall extends Rule implements RuleInterface
{
    const CLASS_ = 'PhpParser\Node\Expr\MethodCall';

    public function getRule(): callable
    {
        $class = self::CLASS_;
        $filter = $this->filter;

        return function($node) use ($class, $filter) {
            return (
                ($node instanceof $class) &&
                (isset($filter['variable']) ? $node->var->name === $filter['variable'] : true) &&
                (isset($filter['name']) ? $node->name === $filter['name'] : true)
            );
        };
    }

    public function allowedOptionalFilter()
    {
        return array('name', 'variable');
    }
}
