<?php

namespace CodingAvenue\Proof\Code\NodeFinder\DataType;

class ArrayFinder extends FinderAbstract
{

    protected $nodes;
    protected $callBack;
    protected $traverseChildren;
    const CLASS_ = '\PhpParser\Node\Expr\Array_';

    public function __construct(array $nodes, array $filter, bool $traverseChildren)
    {
        $this->nodes = $nodes;
        $this->traverseChildren = $traverseChildren;
        $this->callBack = $this->makeCallback($filter);
    }

    public function makeCallback(array $filter)
    {
        $class = self::CLASS_;
        return function($node) use ($class, $filter) {
            return $node instanceof $class;
        };
    }
}