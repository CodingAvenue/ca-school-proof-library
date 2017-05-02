<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Variable;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Interpolation extends Rule implements RuleInterface
{
    const CLASS_ = '\PhpParser\Node\Scalar\Encapsed';

    public function getRule(): callable
    {
        $class = self::CLASS_;

        return function($node) use ($class) {
            return $node instanceof $class;
        };
    }
}
