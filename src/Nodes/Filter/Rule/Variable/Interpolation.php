<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Variable;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

// TODO I think we can add additional ruling to include a variable (multiple variables?). This way user can pinpoint the exact node they wanted.
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
