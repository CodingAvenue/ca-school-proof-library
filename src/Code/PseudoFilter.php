<?php

namespace CodingAvenue\Proof\Code;

class PseudoFilter
{
    /** @var string the pseudo string */
    private $pseudoString;

    /**
     * PseudoFilter applies a filter to the nodes based on the pseudo class
     * It currently only support :first and :last pseudo classes.
     * We should support other pseudo class like :nth-child()
     */
    public function __construct($string = null)
    {
        $this->pseudoString = $string;
    }

    public function filter(array $nodes): array
    {
        if (is_null($this->pseudoString)) {
            return $nodes;
        }
        elseif ($this->pseudoString == 'first') {
            return [$nodes[0]];
        }
        elseif ($this->pseudoString == 'last') {
            return [$nodes[count($nodes) - 1]];
        }
        else {
            throw new \Exception("Unsupported pseudo class " . $this->pseudoString);
        }
    }
}
