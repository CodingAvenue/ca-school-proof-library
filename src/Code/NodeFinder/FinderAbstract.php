<?php

namespace CodingAvenue\Proof\Code\NodeFinder;

use CodingAvenue\Proof\Code\Visitor;
use PhpParser\NodeTraverser;

abstract class FinderAbstract
{
    protected $nodes;
    protected $callBack;
    protected $traverseChildren = true;

    public function find()
    {
        $visitor = new Visitor($this->callBack, $this->traverseChildren);

        $traverser = new NodeTraverser();
        $traverser->addVisitor($visitor);
        $traverser->traverse($this->nodes);

        return $visitor->getFoundNodes();
    }

    abstract function makeCallback(array $filter);
}
