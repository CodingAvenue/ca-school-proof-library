<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule;

use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;
use CodingAvenue\Proof\Nodes\Visitor;
use PhpParser\NodeTraverser;

abstract class Rule implements RuleInterface
{
    protected $filter;
    protected $traverse;

    public function __construct(array $filter = array(), bool $traverse = true)
    {
        $this->filter = $filter;
        $this->traverse = $traverse;
    }

    public function applyRule(array $nodes)
    {
        $visitor = new Visitor($this->getRule(), $this->traverse);

        $traverser = new NodeTraverser();
        $traverser->addVisitor($visitor);
        $traverser->traverse($nodes);

        return $visitor->getFoundNodes();
    }

    abstract function getRule(): callable;
}
