<?php

namespace CodingAvenue\Proof;

use CodingAvenue\Proof\Code\Parser;
use CodingAvenue\Proof\Nodes\Nodes;
use CodingAvenue\Proof\Config;
use CodingAvenue\Proof\BinFinder;

/**
 * @author Sandae P. Macalalag <sandaemc@gmail.com>
 */
class Code {

    private $raw;
    private $config;
    private $binFinder;

    public function __construct()
    {
        $this->config = new Config();

        if (!file_exists($this->getUserCode())) {
            throw new \Exception("Answer file {$this->getUserCode()} not found.");
        }

        $content = file_get_contents($this->getUserCode());
        if (!$content) {
            throw new \Exception("Unable to read answer file {$this->getUserCode()}.");
        }

        $this->raw = $content;
        $this->binFinder = new BinFinder($this->config);
    }

    protected function getUserCode()
    {
        
        return $this->config->getCodeFilePath();
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function getBinFinder()
    {
        return $this->binFinder;
    }

    public function parse()
    {
        return Parser::parse($this->raw);
    }

    public function __toString()
    {
        return $this->raw;
    }

    public function analyzer()
    {
        return new Analyzer($this->getUserCode(), $this->getBinFinder(), $this->config->isSuppressCodingConventionErrors(), $this->config->isSuppressMessDetectionErrors());
    }

    public function evaluator()
    {
        return new Evaluator($this->raw);
    }

    public function getNodes()
    {
        return new Nodes($this->parse());
    }

    public function find(string $selector)
    {
        return $this->getNodes()->find($selector);
    }
}
