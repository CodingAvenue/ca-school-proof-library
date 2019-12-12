<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Function_;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Args_ extends Rule implements RuleInterface
{
    const CLASS_ = '\PhpParser\Node\Arg';

    public function getRule(): callable
    {
        $class = self::CLASS_;

        return function($node) use ($class) {            
            return $node instanceof $class;
        };
    }

    public function allowedOptionalFilter()
    {
        return array();
    }
}
