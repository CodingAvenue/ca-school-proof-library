<?php

namespace CodingAvenue\Proof\Nodes;

use PhpParser\Node;
use PhpParser\NodeVisitorAbstract;
use PhpParser\NodeTraverser;

/**
 * This is a copy of PhpParser\NodeVisitor\FindingVisitor class which isn't available on V3.0.5
 *
 * This visitor can be used to find and collect all nodes satisfying some criterion determined by
 * a filter callback.
 */
class Visitor extends NodeVisitorAbstract {
    /** @var callable Filter callback */
    protected $filterCallback;
    /** @var Node[] Found nodes */
    protected $foundNodes;

    private $traverseChildren;

    public function __construct(callable $filterCallback, bool $traverseChildren = true)
    {
        $this->filterCallback = $filterCallback;
        $this->traverseChildren = $traverseChildren;
    }
    /**
     * Get found nodes satisfying the filter callback.
     *
     * Nodes are returned in pre-order.
     *
     * @return Node[] Found nodes
     */
    public function getFoundNodes()
    {
        return $this->foundNodes;
    }

    public function beforeTraverse(array $nodes)
    {
        $this->foundNodes = [];
        return null;
    }

    public function enterNode(Node $node)
    {
        $filterCallback = $this->filterCallback;
        if ($filterCallback($node)) {
            $this->foundNodes[] = $node;
        }

        if ($this->traverseChildren) {
            return null;
        }

        return NodeTraverser::DONT_TRAVERSE_CHILDREN;
    }
}
