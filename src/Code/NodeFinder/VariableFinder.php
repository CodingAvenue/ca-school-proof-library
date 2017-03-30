<?php

namespace CodingAvenue\Proof\Code\NodeFinder;

class VariableFinder extends FinderAbstract
{
    protected $nodes;
    protected $callBack;
    const CLASS_ = '\PhpParser\Node\Expr\Variable';

    public function __construct(array $nodes, array $filter)
    {
        $this->nodes = $nodes;
        $this->callBack = $this->makeCallback($filter);
    }

    public function makeCallback(array $filter = [])
    {
        $class = self::CLASS_;
        return function($node) use ($class, $filter) {
            if ($filter['name']) {
                return ($node instanceof $class && $node->name === $filter['name']);
            }

            return $node instanceof $class;
        };
    }
}
