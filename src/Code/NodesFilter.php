<?php

namespace CodingAvenue\Proof\Code;

/**
 * This needs to be redesign. The NodeFilter class should not know anything about the Nodes class method naming scheme.
 * It shoulnd't even know about actions, instead it should only have types, attrs, pseudo.
 * Then the Nodes class or another class should deal with resolving the NodeFilter instance.
 */
class NodesFilter
{
    private $actions = array('function', 'variable', 'interpolation', 'operator', 'construct', 'string', 'call', 'datatype', 'arrayfetch');

    private $action;
    private $params = array();
    private $pseudo;
    private $traverseChildren = true;

    public function __construct(bool $traverse)
    {
        $this->traverseChildren = $traverse;
    }

    public function setAction(string $action)
    {
        if (!in_array(strtolower($action), $this->actions)) {
            throw new \Exception("Unsupported action $action.");
        }

        $this->action = 'find' . ucwords($action);
    }

    public function getAction()
    {
        return $this->action;
    }

    public function setParams(array $params)
    {
        $this->params = $params;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function setPseudo(string $pseudo)
    {
        $this->pseudo = $pseudo;
    }

    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function setTraverseChildren(bool $traverse)
    {
        $this->traverseChildren = $traverse;
    }

    public function getTraverseChildren()
    {
        return $this->traverseChildren;
    }

    public function hasAction()
    {
        return isset($this->action);
    }
}
