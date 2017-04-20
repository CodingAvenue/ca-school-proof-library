<?php

namespace CodingAvenue\Proof\Code\NodeFinder;

class StringFinder extends FinderAbstract
{

    protected $nodes;
    protected $callBack;
    protected $traverseChildren;

    public function __construct(array $nodes, array $filter, bool $traverseChildren)
    {
        $this->nodes = $nodes;
        $this->traverseChildren = $traverseChildren;
        $this->callBack = $this->makeCallback($filter);
    }

    public function makeCallback(array $filter)
    {
        return function($node)  {
            return ($node instanceof \PhpParser\Node\Scalar\DNumber
                || $node instanceof \PhpParser\Node\Scalar\EncapsedStringPart
                || $node instanceof \PhpParser\Node\Scalar\LNumber
                || $node instanceof \PhpParser\Node\Scalar\String_);
        };
    }
}