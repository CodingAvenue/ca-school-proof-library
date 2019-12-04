<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Class_;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Namespace_ extends Rule implements RuleInterface
{
    const CLASS_ = '\PhpParser\Node\Stmt\Namespace_';

    public function getRule(): callable
    {
        $class = self::CLASS_;
        $filter = $this->filter;

        return function($node) use ($class, $filter) {
            return (
                ($node instanceof $class) &&
                (isset($filter['name']) ? join('\\', $node->name->parts) === $filter['name'] : true)
            );
        };
    }

    public function allowedOptionalFilter()
    {
        return array('name');
    }
}
