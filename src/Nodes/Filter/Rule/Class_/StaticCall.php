<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Class_;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class StaticCall extends Rule implements RuleInterface
{
    const CLASS_ = 'PhpParser\Node\Expr\StaticCall';

    public function getRule(): callable
    {
        $class = self::CLASS_;
        $filter = $this->filter;

        return function($node) use ($class, $filter) {
            return (
                ($node instanceof $class) &&
                (isset($filter['class']) ? $node->class->parts[0] === $filter['class'] : true) &&
                (isset($filter['method']) ? $node->name === $filter['method'] : true)
            );
        };
    }

    public function allowedOptionalFilter()
    {
        return array('class', 'method');
    }
}
