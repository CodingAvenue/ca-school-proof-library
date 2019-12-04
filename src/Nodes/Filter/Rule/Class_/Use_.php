<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Class_;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Use_ extends Rule implements RuleInterface
{
    const CLASS_ = '\PhpParser\Node\Stmt\Use_';

    public function getRule(): callable
    {
        $class = self::CLASS_;
        $filter = $this->filter;

        return function($node) use ($class, $filter) {
            return (
                ($node instanceof $class) &&
                (isset($filter['class']) ? join('\\', $node->uses[0]->name->parts) === $filter['class'] : true) &&
                (isset($filter['alias']) ? $node->uses[0]->alias === $filter['alias'] : true)
            );
        };
    }

    public function allowedOptionalFilter()
    {
        return array('class', 'alias');
    }
}
