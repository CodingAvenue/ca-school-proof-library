<?php

namespace CodingAvenue\Proof\Code;

use CodingAvenue\Proof\Code\Nodes\SelectorParser;
use CodingAvenue\Proof\Code\Nodes\TokenStream;
use CodingAvenue\Proof\Code\Nodes\StreamReader;

class Nodes
{
    /** @var array of nodes */
    private $nodes;
    private $finder;

    public function __construct(array $nodes)
    {
        $this->nodes = $nodes;
        $this->finder = new NodeFinder();
    }

    /**
     * search the nodes filtered by a selector string.
     *
     * @param string the selector to be used to filter the search
     * @param bool if we override the the behavior on the first round of filter to included descendants.
     *        Used by children() which only apply the filter to it's immediate children
     * @return a new instance of Nodes. or null if no result is found.
     */
    public function find(string $selector, $traverse = true)
    {
        $parser = new SelectorParser($selector);
        $stream = $parser->parse();

        $nodes = $this->nodes;
        $streamReader = new StreamReader($stream);

        // Process the stream of tokens. Apply a series of NodeFilter to the nodes property.
        while ($streamReader->hasUnread()) {
            $firstRead = $streamReader->getReadCount() == 0 ? true : false;

            $nodeFilter = $streamReader->readNext();

            // Used on children() call since it needs to only traverse on the immediate children
            if ($firstRead) {
                $nodeFilter->setTraverseChildren($traverse);
            }

            $nodes = $this->finder->applyFilter($nodeFilter, $nodes);
            
            // Stop the process if the result is empty.
            if (is_null($nodes) || empty($nodes)) {
                break;
            }
        }

        return new self($nodes);
    }

    public function count()
    {
        return count($this->nodes);
    }

    public function text()
    {
        $nodes = $this->find('string');

        $text = '';
        foreach ($nodes->getNodes() as $node) {
            $text .= $node->value;
        }

        return $text;
    }

    public function children($selector = null)
    {
        $subNodes = $this->getSubnode($this->nodes);

        if (is_null($selector)) {
            return $subNodes;
        }
        
        return $subNodes->find($selector, false);
    }

    public function getSubnode(array $nodes)
    {
        $newNodes = [];
        foreach ($nodes as $node) {
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

    public function getNodes()
    {
        return $this->nodes;
    }
}
