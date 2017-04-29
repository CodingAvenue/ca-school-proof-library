<?php

namespace CodingAvenue\Proof\Code\NodeFinder\Variable;

use CodingAvenue\Proof\Code\NodeFinder\FinderAbstract;

class EncapsedFinder extends FinderAbstract {
    protected $nodes;
    protected $callBack;
    protected $traverseChildren;
    
    const CLASS_ = '\PhpParser\Node\Scalar\Encapsed';

    public function __construct(array $nodes, array $filter, $traverseChildren)
    {
        $this->nodes = $nodes;
        $this->traverseChildren = $traverseChildren;
        $this->callBack = $this->makeCallback($filter);
    }

    public function makeCallback(array $filter = [])
    {
        $class = self::CLASS_;
        return function($node) use ($class) {
            return $node instanceof $class;
        };
    }
}
