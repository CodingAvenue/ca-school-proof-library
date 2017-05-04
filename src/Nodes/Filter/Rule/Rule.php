<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule;

use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;
use CodingAvenue\Proof\Nodes\Visitor;
use PhpParser\NodeTraverser;

/**
 * Abstract class for all Rule that is used by the Filter class
 *
 * TODO a Rule subclass must know what it's acceptable filter's are
 * This way we can then throw an Exception if the user pass a lot of filter's that the Rule cannot use
 */
abstract class Rule implements RuleInterface
{
    /** @var array $filter the array of additional filter for this rule */
    protected $filter;

    /** @var bool $traverse true if the filter will be used not only on the immediate children, false otherwise */
    protected $traverse;

    public function __construct(array $filter = array(), bool $traverse = true)
    {
        $this->filter = $filter;
        $this->traverse = $traverse;

        $this->checkOptionalFilter();
    }

    /**
     * applyRule() Traverse through the nodes and run the rule callback on each found node
     * Returns the nodes that returns true on the callback
     *
     * @param array $nodes the nodes to be filtered
     * @return array the nodes that have been filtered.
     */
    public function applyRule(array $nodes)
    {
        $visitor = new Visitor($this->getRule(), $this->traverse);

        $traverser = new NodeTraverser();
        $traverser->addVisitor($visitor);
        $traverser->traverse($nodes);

        return $visitor->getFoundNodes();
    }

    /**
     * Checks the filter property of this Rule and validate it agains't the allowedOptionalFilter list
     * This allows us to inform the user that they are passing something on the filter that we cannot use
     * 
     * @throws Exception when one of the filter property keys is not on the allowed optional filter list.
     */
    public function checkOptionalFilter()
    {
        $allowed = $this->allowedOptionalFilter();

        foreach ($this->filter as $key => $value) {
            if (!in_array($key, $allowed)) {
                throw new \Exception(get_class($this) . " allowed optional filters are " . implode(",", $allowed));
            }
        }
    }

    /**
     * abstract function getRule() Returns the callback that will be used to test against each node on the NodeTraverser class.
     *
     * @return callable $callBack
     */
    abstract function getRule(): callable;

    /**
     * abstract function allowedOptionalFilter()
     * a list of allowed optional filter of this rules
     * 
     * @return array The allowed optional filter for this rule.
     */
    abstract function allowedOptionalFilter();
}
