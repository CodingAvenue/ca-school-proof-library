<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Construct;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Include_ extends Rule implements RuleInterface
{
    const CLASS_ = 'PhpParser\Node\Expr\Include_';

    public function getRule(): callable
    {
        $class = self::CLASS_;
        $filter = $this->filter;
        $includeTypes = $this->includeTypes();

        return function($node) use ($class, $filter, $includeTypes) {
            return (
                ($node instanceof $class)
                && (isset($filter['type']) ? strtolower($includeTypes[$filter['type']]) == $node->type : true)
            );
        };
    }

    public function allowedOptionalFilter()
    {
        return array('type');
    }

    private function includeTypes()
    {
        return array(
            'include' => 1,
            'include_once' => 2,
            'require' => 3,
            'require_once' => 4
        );
    }
}
