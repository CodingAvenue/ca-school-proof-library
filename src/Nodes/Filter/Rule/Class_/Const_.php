<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Class_;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Const_ extends Rule implements RuleInterface
{
    const CLASS_ = 'PhpParser\Node\Stmt\ClassConst';

    public function getRule(): callable
    {
        $class = self::CLASS_;
        $filter = $this->filter;

        return function($node) use ($class, $filter) {
            return (
                ($node instanceof $class) &&
                (isset($filter['name']) ? $node->consts[0]->name === $filter['name'] : true)
            );
        };
    }

    public function allowedOptionalFilter()
    {
        return array('name');
    }
}
