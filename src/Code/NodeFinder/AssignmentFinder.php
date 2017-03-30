<?php

namespace CodingAvenue\Proof\Code\NodeFinder;

class AssignmentFinder extends FinderAbstract
{
    /** @var array of nodes The nodes to be search */
    protected $nodes;
    /** @var callable The filter callback */
    protected $callBack;
    /** @const string The class name that the node instance should match. */
    const CLASS_ = '\PhpParser\Node\Expr\Assign';

    /**
     * Construct an AssignmentFinder
     * Finds all assignment operator nodes
     *
     * @param array $nodes The nodes to be search
     * @param array $filter the filter to be used on the callback
     */
    public function __construct(array $nodes, array $filter)
    {
        $this->nodes = $nodes;
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
            if ($filter['variable']) {
                return ($node instanceof $class && $node->var->name === $filter['variable']);
            }

            return $node instanceof $class;
        };
    }
}
