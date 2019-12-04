<?php

namespace CodingAvenue\Proof\Nodes\Filter;

use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleFactory;

class Instantiate_ extends Filter implements FilterInterface
{
    public function getRuleClass()
    {
        return RuleFactory::createRule('instantiate', $this->getRuleFilters(), $this->traverse);   
    }

    public function getRuleFilters()
    {
        return $this->attributes;
    }
}
