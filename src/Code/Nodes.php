<?php

namespace CodingAvenue\Proof\Code;

use CodingAvenue\Proof\Code\PseudoFilter;
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
     * @return a new instance of Nodes. or null if no result is found.
     */
    public function find(string $selector)
    {
        $parser = new SelectorParser($selector);
        $stream = $parser->parse();

        $nodes = $this->nodes;
        $streamReader = new StreamReader($stream);

        // Process the stream of tokens by group. The StreamReader class handles how the tokens are grouped.
        // Each group is applied as a filter to the current $nodes default to the object $nodes attribute.
        while ($streamReader->hasUnread()) {
            list($method, $params, $pseudo, $traverseChildren) = $streamReader->readNext();

            if (isset($method)) {
                $method = 'find' . $method;

                if (!method_exists($this->finder, $method)) {
                    throw new \Exception("Unknown method $method for NodeFinder class.");
                }

                $nodes = $this->finder->$method($nodes, $params, $traverseChildren);

                // Stop the process if the result is empty.
                if (is_null($nodes) || empty($nodes)) {
                    break;
                }
            }

            $pseudoFilter = new PseudoFilter($pseudo);
            $nodes = $pseudoFilter->filter($nodes);
        }

        return new self($nodes);
    }

    public function count()
    {
        return count($this->nodes);
    }

    // Needs to code the if selector is not null.
    public function children($selector = null)
    {
        if (is_null($selector)) {
            $newNodes = [];
            foreach ($this->nodes as $node) {
                foreach ($node->getSubNodeNames as $subnode) {
                    $newNodes[] = $node->$subnode;
                }
            }

            return new self($newNodes);
        }
        
    }
}
