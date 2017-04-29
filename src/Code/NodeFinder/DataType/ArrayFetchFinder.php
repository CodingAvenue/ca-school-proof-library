<?php

namespace CodingAvenue\Proof\Code\NodeFinder\DataType;

class ArrayFetchFinder extends FinderAbstract
{

    protected $nodes;
    protected $callBack;
    protected $traverseChildren;
    const CLASS_ = '\PhpParser\Node\Expr\ArrayDimFetch';

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
            if (isset($filter['variable'])) {
                return $node instanceof $class && $node->var->name === $filter['variable'];
            }
            
            return $node instanceof $class;
        };
    }
}