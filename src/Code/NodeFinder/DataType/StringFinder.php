<?php

namespace CodingAvenue\Proof\Code\NodeFinder\DataType;

class StringFinder extends FinderAbstract
{

    protected $nodes;
    protected $callBack;
    protected $traverseChildren;

    const CLASS_ = '\PhpParser\Node\Scalar\String_';
    private $types = array(
        'single'    => 1,
        'double'    => 2,
        'heredoc'   => 3,
        'nowdoc'    => 4
    );

    public function __construct(array $nodes, array $filter, bool $traverseChildren)
    {
        $this->nodes = $nodes;
        $this->traverseChildren = $traverseChildren;
        $this->callBack = $this->makeCallback($filter);
    }

    public function makeCallback(array $filter)
    {
        $class = self::CLASS_;
        $kind = $this->getKindType($filter);
        return function($node) use ($class, $filter, $kind) {
            return (
                $node instanceof $class
                && (isset($filter['value']) ? $node->value === $filter['value'] : true)
                && (!is_null($kind) ? $node->getAttribute('kind') === $kind : true)
            );
        };
    }

    public function getKindType($filter)
    {
        if(isset($filter['type'])) {
            if (array_key_exists($filter['type'])) {
                return $this->types[$filter['type']];
            }

            throw new \Exception("Unknown type {$filter['type']}. Supported types are " . implode(', ', array_keys($this->types)));
        }

        return null;
    }
}