<?php

namespace CodingAvenue\Proof\Nodes;

use CodingAvenue\Proof\SelectorParser\Parser;
use CodingAvenue\Proof\SelectorParser\Transformer\ArrayTransformer;
use CodingAvenue\Proof\Nodes\Filter\FilterFactory;

class Nodes
{
    private $nodes = array();

    public function __construct(array $nodes)
    {
        $this->nodes = $nodes;
    }

    public function find(string $selector, bool $traverse = true): self
    {
        $parsed = $this->parseSelector($selector);
        $filter = FilterFactory::createFilter($parsed['node'], $parsed['attribute'], $traverse);
        $filteredNodes = $filter->applyFilter($this->nodes);

        return new self($filteredNodes);
    }

    public function children(string $selector = null): self
    {
        if (is_null($selector)) {
            return $this->getSubnode();
        }

        return $this->find($selector, false);
    }

    public function text(): string
    {
        $nodes = $this->find('string');
        $text = '';

        foreach ($nodes->getNodes() as $node) {
            $text .= $node->value;
        }

        return $text;
    }

    public function count()
    {
        return count($this->nodes);
    }

    public function getSubnode()
    {
        $newNodes = [];
        foreach ($this->getNodes() as $node) {
            foreach ($node->getSubNodeNames() as $subNode) {
                if (is_array($node->$subNode)) {
                    $newNodes = array_merge($newNodes, $node->$subNode);
                    continue;
                }
                elseif ($node->$subNode instanceof \PhpParser\NodeAbstract) {
                    $newNodes[] = $node->$subNode;
                    continue;
                }

                throw new \Exception("Unknown node type " . gettype($node->$subNode));
            }
        }
        
        return new self($newNodes);
    }

    public function parseSelector(string $selector)
    {
        $parser = new Parser($selector);
        $stream = $parser->parse();

        $transformer = new ArrayTransformer($stream);
        return $transformer->transform();
    }
}
