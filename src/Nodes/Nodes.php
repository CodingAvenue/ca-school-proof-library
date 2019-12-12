<?php

namespace CodingAvenue\Proof\Nodes;

use CodingAvenue\Proof\SelectorParser\Parser;
use CodingAvenue\Proof\SelectorParser\Transformer\ArrayTransformer;
use CodingAvenue\Proof\Nodes\Filter\FilterFactory;

/**
 * Nodes Class - Takes the result from the PHP Parser and allows users to traverse and find specific node or nodes
 * through a selector.
 */
class Nodes
{
    /** @var array $nodes Array of nodes from the result of the PHP Parser */
    private $nodes;

    /**
     * Constructor
     * 
     * @param array $nodes the array of node which usually comes from the result of the PHP Parser
     */
    public function __construct(array $nodes)
    {
        $this->nodes = $nodes;
    }

    /**
     * find() - Takes a selector string and use it to filter the nodes
     *
     * @param string $selector the selector string which will be used to filter the nodes.
     * @param bool $traverse True if we want to traverse to inner nodes for searching, false otherwise. Default to true
     * @return a new instance of the Nodes class with the filtered nodes.
     */
    public function find(string $selector, bool $traverse = true): self
    {
        $parsed = $this->parseSelector($selector);
        $filter = FilterFactory::createFilter($parsed['node'], isset($parsed['attribute']) ? $parsed['attribute'] : array(), $traverse);
        $filteredNodes = $filter->applyFilter($this->nodes);

        return new self($filteredNodes);
    }

    /**
     * children() - returns it's immediate children nodes only, can be filtered by supplying an optional selector string
     *
     * @param string $selector an optional selector string to be used to filter the nodes on it's immediate children only.
     * @return a new instance of the Nodes class with the filtered nodes.
     */
    public function children(string $selector = null): self
    {
        $subnodes = $this->getSubnode();

        if (is_null($selector)) {
            return $subnodes;
        }

        return $subnodes->find($selector, false);
    }

    /**
     * text() - Returns the string literal of any nodes 
     */ 
    public function text(): string
    {
        $nodes = $this->find('datatype[name="string"]');
        $text = '';

        foreach ($nodes->getNodes() as $node) {
            $text .= $node->value;
        }

        return $text;
    }

    /**
     * Returns the number of nodes in this instance. Note that this only counts the top parent counts
     * meaning, if a node has a subnode, those will not be included on the count.
     */
    public function count()
    {
        return count($this->nodes);
    }

    /**
     * getSubnode() - Returns a new instance of the Nodes class with it's immediate subnodes 
     */
    public function getSubnode(): self
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

                // Ignore subnode that isn't a class.
                //throw new \Exception("Unknown node type " . gettype($node->$subNode));
            }
        }
        
        return new self($newNodes);
    }

    public function getSubnodeByIndex(integer $index)
    {
        if (array_key_exists($index, $this->getNodes())) {
            return new self([$this->getNodes()[$index]]);
        }

        return new self([]);
    }

    /**
     * parseSelector() - Parses the selector string and returns an array of the parsed string
     */
    public function parseSelector(string $selector)
    {
        $parser = new Parser($selector);
        $stream = $parser->parse();

        $transformer = new ArrayTransformer($stream);
        return $transformer->transform();
    }

    public function getNodes()
    {
        return $this->nodes;
    }
}
