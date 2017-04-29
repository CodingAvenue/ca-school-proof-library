<?php

namespace CodingAvenue\Proof\Code\NodeFinder\Operator\Arithmetic;

use CodingAvenue\Proof\Code\NodeFinder\FinderAbstract;

class ModuloFinder extends FinderAbstract
{
    /** @var array of nodes to be search */
    protected $nodes;
    /** @var callable The filter callback */
    protected $callBack;
    protected $traverseChildren;
    /** @const string The class name that the node instance should match. */
    const CLASS_ = '\PhpParser\Node\Expr\BinaryOp\Mod';

    /**
     * Constructs an ModuloFinder
     * Finds all modulo operator nodes
     *
     * @param array $nodes the nodes to be searched.
     * @param array $filter the filter to be used.
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
        return function($node) use($class, $filter) {
            return $node instanceof $class;
        };
    }
}
