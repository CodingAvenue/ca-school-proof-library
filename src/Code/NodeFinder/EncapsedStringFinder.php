<?php

namespace CodingAvenue\Proof\Code\NodeFinder;

class EncapsedStringFinder extends FinderAbstract {
    protected $nodes;
    protected $callBack;
    protected $traverseChildren;
    const CLASS_ = '\PhpParser\Node\Scalar\EncapsedStringPart';

    public function __construct(array $nodes, array $filter, bool $traverseChildren)
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
