<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Class_;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Interface_ extends Rule implements RuleInterface
{
    const CLASS_ = 'PhpParser\Node\Stmt\Interface_';

    public function getRule(): callable
    {
        $class = self::CLASS_;
        $filter = $this->filter;

        return function($node) use ($class, $filter) {
            return (
                ($node instanceof $class) &&
                (isset($filter['name']) ? $node->name === $filter['name'] : true) &&
                (isset($filter['method']) 
                    ? count(
                            array_filter(
                                $node->stmts, function($k) use ($filter) {
                                    return $k->name === $filter['method'];
                                }
                            )
                        ) > 0
                    : true
                )
            );
        };
    }

    public function allowedOptionalFilter()
    {
        return array('name', 'method');
    }
}
