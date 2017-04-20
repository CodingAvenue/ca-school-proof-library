<?php

namespace CodingAvenue\Proof\Code;

class NodesFilter
{
    private $actions = array('function', 'variable', 'interpolation', 'encapsedstring', 'operator', 'construct', 'string');

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
