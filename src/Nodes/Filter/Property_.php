<?php

namespace CodingAvenue\Proof\Nodes\Filter;

use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleFactory;

class Property_ extends Filter implements FilterInterface
{
    public function getRuleClass()
    {
        return RuleFactory::createRule('property', $this->getRuleFilters(), $this->traverse);   
    }

    public function getRuleFilters()
    {
        return $this->attributes;
    }
}
