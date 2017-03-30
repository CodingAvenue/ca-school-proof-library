<?php

namespace CodingAvenue\Proof\Code\NodeFinder;

class AdditionFinder extends FinderAbstract
{
    /** @var array of nodes to be search */
    protected $nodes;
    /** @var callable The filter callback */
    protected $callBack;
    /** @const string The class name that the node instance should match. */
    const CLASS_ = '\PhpParser\Node\Expr\BinaryOp\Plus';

    /**
     * Constructs an AdditionFinder
     * Finds all addition operator nodes
     *
     * @param array $nodes the nodes to be searched.
     * @param array $filter the filter to be used.
     */
    public function __construct(array $nodes, array $filter)
    {
        $this->nodes = $nodes;
        $this->callBack = $this->makeCallback();
    }

    /**
     * Creates a callback for the NodeVisitor to use.
     * @return callable.
     */
    public function makeCallback()
    {
        $class = self::CLASS_;
        return function($node) use($class) {
            return $node instanceof $class;
        };
    }
}
