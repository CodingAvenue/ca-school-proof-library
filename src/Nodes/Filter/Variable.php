<?php

namespace CodingAvenue\Proof\Nodes\Filter;

use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleFactory;

class Variable extends Filter implements FilterInterface
{
    public function getRuleClass()
    {
        return RuleFactory::createRule('variable', $this->getNameSpaceparts(), $this->getRuleFilters(), $this->traverse);   
    }

    public function getRuleFilters()
    {
        return $this->attributes;
    }

    public function getNameSpaceParts(): array
    {
        return array(
            "Variable"
        );
    }
}
