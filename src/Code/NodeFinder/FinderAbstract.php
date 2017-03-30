<?php

namespace CodingAvenue\Proof\Code\NodeFinder;

use PhpParser\NodeVisitor\FindingVisitor;
use PhpParser\NodeTraverser;

abstract class FinderAbstract
{
    protected $nodes;
    protected $callBack;

    public function find()
    {
        $visitor = new FindingVisitor($this->callBack);

        $traverser = new NodeTraverser();
        $traverser->addVisitor($visitor);
        $traverser->traverse($this->nodes);

        return $visitor->getFoundNodes();
    }

    abstract function makeCallback();
}
