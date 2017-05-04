<?php

namespace CodingAvenue\Proof\Nodes\Filter;

/**
 * Base class for all Filter classes. 
 * A Filter class does not hold the Ruling on how to filter the nodes. That task is given on the Rule class
 * The Filter class is to get the instance of a Rule class which depends on what attributes it has, then apply the rule to the node
 */
abstract class Filter implements FilterInterface
{
    /** @var string $name the name of the Filter class */
    protected $name;

    /** @var array $attributes An array of attributes that would be used to identify the Rule class and the optional filter for the Rule class */
    protected $attributes = array();

    /** @var bool $traverse true if we would want to apply the Rule to the nodes descendant tree, false otherwise */
    protected $traverse;

    public function __construct(string $name, array $attributes, bool $traverse = true)
    {
        $this->name = $name;
        $this->attributes = $attributes;
        $this->traverse = $traverse;
    }

    /**
     * Takes an array of nodes, gets the instance of the Rule class for this Filter then call the Rule applyRule method to filter the nodes
     *
     * @param array $nodes the nodes to be filtered
     * @return array $nodes the filtered nodes
     */
    public function applyFilter(array $nodes): array
    {
        $rule = $this->getRuleClass();
        
        return $rule->applyRule($nodes);
    }

    /**
     * abstract function to get the instance of the Rule class to be used by this Filter class
     */
    abstract function getRuleClass();

    /**
     * abstract function to get the list of optional filter to be passed to the Rule class
     */
    abstract function getRuleFilters();
}
