<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\DataType;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Arrayfetch extends Rule implements RuleInterface
{
    const CLASS_ = '\PhpParser\Node\Expr\ArrayDimFetch';

    public function getRule(): callable
    {
        $class = self::CLASS_;
        $filter = $this->filter;

        return function($node) use ($class, $filter) {
            if (isset($filter['variable'])) {
                return $node instanceof $class && $node->var->name === $filter['variable'];
            }
            
            return $node instanceof $class;
        };
    }
}
