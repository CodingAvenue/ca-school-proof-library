<?php

namespace CodingAvenue\Proof\Nodes\Filter;

abstract class Filter implements FilterInterface
{
    protected $name;
    protected $attributes = array();
    protected $traverse;

    public function __construct(string $name, array $attributes, bool $traverse = true)
    {
        $this->name = $name;
        $this->attributes = $attributes;
        $this->traverse = $traverse;
    }

    public function applyFilter(array $nodes): array
    {
        $rule = $this->getRuleClass();
        
        return $rule->applyRule($nodes);
    }

    abstract function getRuleClass();

    abstract function getRuleFilters();
}
