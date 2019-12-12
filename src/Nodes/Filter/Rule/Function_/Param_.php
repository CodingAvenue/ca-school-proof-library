<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Function_;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Param_ extends Rule implements RuleInterface
{
    const CLASS_ = '\PhpParser\Node\Param';

    public function getRule(): callable
    {
        $class = self::CLASS_;
        $filter = $this->filter;

        return function($node) use ($class, $filter) {
            return (
                $node instanceof $class &&
                (isset($filter['name']) ? $filter['name'] === $node->name : true) &&
                (isset($filter['type']) ? $filter['type'] === $node->type : true)
            );
        };
    }

    public function allowedOptionalFilter()
    {
        return array('name', 'type');
    }
}
