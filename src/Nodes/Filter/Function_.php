<?php

namespace CodingAvenue\Proof\Nodes\Filter;

use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleFactory;

class Function_ extends Filter implements FilterInterface
{
    public function getRuleClass()
    {
        if (isset($this->attributes['name'])) {
            return RuleFactory::createRule('function', $this->getRuleFilters(), $this->traverse);
        }
        else if (isset($this->attributes['type'])) {
            return RuleFactory::createRule('anonymous', $this->getRuleFilters(), $this->traverse);
        }
    }

    public function getRuleFilters()
    {
        return $this->attributes;
    }
}
