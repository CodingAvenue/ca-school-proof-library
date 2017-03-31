<?php

namespace CodingAvenue\Proof\Code\NodeFinder;

class FunctionFinder extends FinderAbstract
{
    protected $nodes;
    protected $callback;
    const CLASS_ = '\PhpParser\Node\Stmt\Function_';

    public function __construct(array $nodes, array $filter)
    {
        $this->nodes = $nodes;
        $this->callback = $this->makeCallback($filter);
    }

    public function makeCallback(array $filter)
    {
        $class = self::CLASS_;
        return function($node) use ($class, $filter) {
            return ($node instanceof $class && $node->name === $filter['name']);
        };
    }
}