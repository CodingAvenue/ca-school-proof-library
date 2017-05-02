<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Operator\String;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class AssignConcat extends Rule implements RuleInterface
{
    const CLASS_ = '\PhpParser\Node\Expr\AssignOp\Concat';

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
}
