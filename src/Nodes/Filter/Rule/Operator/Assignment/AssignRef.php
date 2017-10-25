<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Assignment;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class AssignRef extends Rule implements RuleInterface
{
    const CLASS_ = '\PhpParser\Node\Expr\AssignRef';

    public function getRule(): callable
    {
        $class = self::CLASS_;
        $filter = $this->filter;
        
        return function($node) use ($class, $filter) {
            return (
                $node instanceof $class
                && (
                    isset($filter['variable'])
                        ? $node->var->name === $filter['variable']
                        : true
                )
                && (
                    isset($filter['variable-ref'])
                        ? $node->expr->name === $filter['variable-ref']
                        : true
                )
            );
        };
    }

    public function allowedOptionalFilter()
    {
        return array('variable', 'variable-ref');
    }
}
