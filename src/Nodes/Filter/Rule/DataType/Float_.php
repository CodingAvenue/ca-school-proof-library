<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\DataType;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Float_ extends Rule implements RuleInterface
{
    const CLASS_ = '\PhpParser\Node\Scalar\DNumber';

    public function getRule(): callable
    {
        $class = self::CLASS_;
        $filter = $this->filter;

        
        return function($node) use ($class, $filter, $kind) {
            return (
                $node instanceof $class
                && (isset($filter['value']) ? $node->value === $filter['value'] : true)
            );
        };
    }

    public function allowedOptionalFilter()
    {
        return array('value');
    }
}
