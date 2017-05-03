<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule;

/**
 * RuleInterface The interface for every Rule class
 * Requires a single method to be implemented
 */
interface RuleInterface
{
    /**
     * applyRule The only method that needs to be implemented by this Interface
     * Applies the rule of the class agains't the array of nodes
     *
     * @param array $nodes the nodes that will be used against this rule
     */
    public function applyRule(array $nodes);
}
