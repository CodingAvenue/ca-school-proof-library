<?php

namespace CodingAvenue\Proof;

use CodingAvenue\Proof\Code\Parser;
use CodingAvenue\Proof\Nodes\Nodes;
use CodingAvenue\Proof\Config;
use CodingAvenue\Proof\BinFinder;

/**
 * Code class of the Proof Library
 * The main entry point of using this library, can analyze, evaluate and parsed a php file.
 *
 * @author Sandae P. Macalalag <sandaemc@gmail.com>
 */
class Code {

    /** @var string $raw the content of the php file */
    private $raw;

    /** @var Config $config The Config instance */
    private $config;

    /** @var BinFinder $binFinder the BinFinder instance */
    private $binFinder;

    /**
     * Constructor
     */
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

    /**
     * Returns the php file that this Proof Library is referring to. 
     * Default to `/code` but can be configured via the `proof.json` file
     */
    protected function getUserCode()
    {
        
        return $this->config->getCodeFilePath();
    }

    /**
     * Returns the Config instance
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Returns the BinFinder instance
     */
    public function getBinFinder()
    {
        return $this->binFinder;
    }

    /**
     * Parses the php file content using the PHP Parser and returns the result
     */
    public function parse()
    {
        return Parser::parse($this->raw);
    }

    /**
     * Returns the content of the php file
     */
    public function __toString()
    {
        return $this->raw;
    }

    /**
     * Returns the instance of the Analyzer class 
     */
    public function analyzer()
    {
        return new Analyzer($this->getUserCode(), $this->getBinFinder(), $this->config->isSuppressCodingConventionErrors(), $this->config->isSuppressMessDetectionErrors());
    }

    /**
     * Returns the instance of the Evaluator class
     */
    public function evaluator()
    {
        return new Evaluator($this->getUserCode(), $this->getBinFinder()->getEvalRunner());
    }

    /**
     * Returns the instance of the Nodes class with the parsed php code
     */
    public function getNodes()
    {
        return new Nodes($this->parse());
    }

    /**
     * Accepts a selector string that will filter the nodes and return a new instance of the Nodes class
     */
    public function find(string $selector)
    {
        return $this->getNodes()->find($selector);
    }

    /**
     * Checks if the user Submitted code first line is the php start tag `<?php`.
     */
    public function codeStartCheck()
    {
        $length = strlen(PHP_EOL);
        return (substr($this->raw, 0, $length) === PHP_EOL) ? false : true;
    }
}
