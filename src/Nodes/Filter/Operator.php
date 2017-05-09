<?php

namespace CodingAvenue\Proof\Nodes\Filter;

use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleFactory;

/**
 * Operator Filter class
 * Handles php operators filters
 */
class Operator extends Filter implements FilterInterface
{
    public function getRuleClass()
    {
        return RuleFactory::createRule($this->attributes['name'], $this->getRuleFilters(), $this->traverse);   
    }

    public function getRuleFilters()
    {
        $attributes = $this->attributes;

        unset($attributes['name']);
        return $attributes;
    }
}
