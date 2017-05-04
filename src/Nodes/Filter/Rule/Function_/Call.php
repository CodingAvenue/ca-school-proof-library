<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Function_;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Call extends Rule implements RuleInterface
{
    const CLASS_ = '\PhpParser\Node\Expr\FuncCall';

    public function getRule(): callable
    {
        $class = self::CLASS_;
        $filter = $this->filter;

        return function($node) use ($class, $filter) {
            if (isset($filter['name'])) {
                return ($node instanceof $class && $node->name->parts[0] === $filter['name']);
            }
            
            return $node instanceof $class;
        };
    }

    public function allowedOptionalFilter()
    {
        return array('name');
    }
}
