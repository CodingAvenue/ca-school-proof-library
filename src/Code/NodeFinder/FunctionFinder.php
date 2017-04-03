<?php

namespace CodingAvenue\Proof\Code\NodeFinder;

class FunctionFinder extends FinderAbstract
{
    protected $nodes;
    protected $callBack;
    protected $traverseChildren;
    const CLASS_ = '\PhpParser\Node\Stmt\Function_';

    public function __construct(array $nodes, array $filter, bool $traverseChildren = true)
    {
        $this->nodes = $nodes;
        $this->traverseChildren = $traverseChildren;
        $this->callBack = $this->makeCallback($filter);
    }

    public function makeCallback(array $filter)
    {
        $class = self::CLASS_;
        return function($node) use ($class, $filter) {
            return ($node instanceof $class && $node->name === $filter['name']);
        };
    }
}