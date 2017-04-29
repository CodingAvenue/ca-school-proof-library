<?php

namespace CodingAvenue\Proof\Code\NodeFinder\Operator\Comparison;

use CodingAvenue\Proof\Code\NodeFinder\FinderAbstract;

class GreaterFinder extends FinderAbstract
{
    /** @var array of nodes The nodes to be search */
    protected $nodes;
    /** @var callable The filter callback */
    protected $callBack;
    protected $traverseChildren;
    /** @const string The class name that the node instance should match. */
    const CLASS_ = '\PhpParser\Node\Expr\BinaryOp\Greater';

    /**
     * Construct an GreaterFinder
     * Finds all greater comparison nodes
     *
     * @param array $nodes The nodes to be search
     * @param array $filter the filter to be used on the callback
     */
    public function __construct(array $nodes, array $filter, bool $traverseChildren)
    {
        $this->nodes = $nodes;
        $this->traverseChildren = $traverseChildren;
        $this->callBack = $this->makeCallback($filter);
    }

    /**
     * Creates a callback for the NodeVisitor to use.
     * @return callable.
     */
    public function makeCallback(array $filter)
    {
        $class = self::CLASS_;
        return function($node) use ($class, $filter) {
            return $node instanceof $class;
        };
    }
}
