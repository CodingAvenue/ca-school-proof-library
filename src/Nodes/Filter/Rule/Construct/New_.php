<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Construct;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class New_ extends Rule implements RuleInterface
{
    const CLASS_ = '\PhpParser\Node\Expr\New_';

    public function getRule(): callable
    {
        $class = self::CLASS_;
        $filter = $this->filter;

        return function($node) use ($class, $filter) {
            return (
                $node instanceof $class
                && (
                    isset($filter['class'])
                        ? $node->class->parts[0] === $filter['class']
                        : true
                )
            );
        };
    }

    public function allowedOptionalFilter()
    {
        return array('class');
    }
}
