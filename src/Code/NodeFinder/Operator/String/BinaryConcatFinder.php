<?php

namespace CodingAvenue\Proof\Code\NodeFinder\Operator\String;

use CodingAvenue\Proof\Code\NodeFinder\FinderAbstract;

class BinaryConcatFinder extends FinderAbstract
{
    protected $nodes;
    protected $callBack;
    protected $traverseChildren;
    const CLASS_ = '\PhpParser\Node\Expr\BinaryOp\Concat';

    public function __construct(array $nodes, array $filter, bool $traverseChildren = true)
    {
        $this->nodes = $nodes;
        $this->traverseChildren = $traverseChildren;
        $this->callBack = $this->makeCallback($filter);
    }

    public function makeCallback(array $filter)
    {
        $class = self::CLASS_;
        
        return function($node) use ($class) {
            return $node instanceof $class;
        };
    }
}
