<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Function_;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Function_ extends Rule implements RuleInterface
{
    const CLASS_ = '\PhpParser\Node\Stmt\Function_';

    public function getRule(): callable
    {
        $class = self::CLASS_;
        $filter = $this->filter;

        return function($node) use ($class, $filter) {
            if (isset($filter['name'])) {
                return $node instanceof $class && $node->name === $filter['name'];
            }
            
            return $node instanceof $class;
        };
    }
}
