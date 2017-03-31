<?php

namespace CodingAvenue\Proof\Code\NodeFinder;

class EncapsedFinder extends FinderAbstract {
    protected $nodes;
    protected $callBack;
    const CLASS_ = '\PhpParser\Node\Scalar\Encapsed';

    public function __construct(array $nodes)
    {
        $this->nodes = $nodes;
        $this->callBack = $this->makeCallback();
    }

    public function makeCallback(array $filter = [])
    {
        $class = self::CLASS_;
        return function($node) use ($class) {
            return $node instanceof $class;
        };
    }
}
