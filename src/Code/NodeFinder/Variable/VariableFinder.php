<?php

namespace CodingAvenue\Proof\Code\NodeFinder\Variable;

use CodingAvenue\Proof\Code\NodeFinder\FinderAbstract;

class VariableFinder extends FinderAbstract
{
    protected $nodes;
    protected $callBack;
    protected $traverseChildren;
    
    const CLASS_ = '\PhpParser\Node\Expr\Variable';

    public function __construct(array $nodes, array $filter, bool $traverseChildren)
    {
        $this->nodes = $nodes;
        $this->traverseChildren = $traverseChildren;
        $this->callBack = $this->makeCallback($filter);
    }

    public function makeCallback(array $filter = [])
    {
        $class = self::CLASS_;
        return function($node) use ($class, $filter) {
            if (isset($filter['name'])) {
                return ($node instanceof $class && $node->name === $filter['name']);
            }

            return $node instanceof $class;
        };
    }
}
