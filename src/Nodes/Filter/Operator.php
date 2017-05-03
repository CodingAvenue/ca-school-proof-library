<?php

namespace CodingAvenue\Proof\Nodes\Filter;

use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleFactory;

class Operator extends Filter implements FilterInterface
{
    public function getRuleClass()
    {
        return RuleFactory::createRule($this->attributes['name'], $this->getNameSpaceparts(), $this->getRuleFilters(), $this->traverse);   
    }

    public function getRuleFilters()
    {
        $attributes = $this->attributes;

        unset($attributes['name']);
        return $attributes;
    }

    public function getNameSpaceParts(): array
    {
        return array(
            "Operator\Arithmetic",
            "Operator\Comparison",
            "Operator\String",
            "Operator"
        );
    }
}
