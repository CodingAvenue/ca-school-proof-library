<?php

namespace CodingAvenue\Proof;

use CodingAvenue\Proof\Code\Parser;
use CodingAvenue\Proof\Code\Nodes;

/**
 * @author Sandae P. Macalalag <sandaemc@gmail.com>
 */
class Code {

    const ANSWER_FILE_PATH = '/code';

    private $raw;
    private $userCode;

    public function __construct()
    {
        $this->userCode = $this->getUserCode();
        if (!file_exists($this->userCode)) {
            throw new \Exception("Answer file {$this->userCode} not found.");
        }

        $content = file_get_contents($this->userCode);
        if (!$content) {
            throw new \Exception("Unable to read answer file {$this->userCode}.");
        }

        $this->raw = $content;
    }

    protected function getUserCode()
    {
        return self::ANSWER_FILE_PATH;
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
        return new Analyzer($this->userCode);
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
