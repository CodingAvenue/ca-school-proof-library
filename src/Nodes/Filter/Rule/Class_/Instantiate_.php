<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Class_;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Instantiate_ extends Rule implements RuleInterface
{
    const CLASS_ = 'PhpParser\Node\Expr\New_';

    public function getRule(): callable
    {
        $class = self::CLASS_;
        $filter = $this->filter;

        return function($node) use ($class, $filter) {
            return (
                ($node instanceof $class) &&
                (isset($filter['class']) ? $node->class->parts[0] === $filter['class'] : true)
            );
        };
    }

    public function allowedOptionalFilter()
    {
        return array('class');
    }
}
