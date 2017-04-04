<?php

namespace CodingAvenue\Proof;

use CodingAvenue\Proof\Code\Parser;
use CodingAvenue\Proof\Code\Nodes;

/**
 * @author Sandae P. Macalalag <sandaemc@gmail.com>
 */
class Code {

    const ANSWER_FILE_PATH = './code';

    private $raw;

    public function __construct()
    {
        if (!file_exists(self::ANSWER_FILE_PATH)) {
            throw new \Exception("Answer file (./code) not found.");
        }

        $content = file_get_contents(self::ANSWER_FILE_PATH);
        if (!$content) {
            throw new \Exception("Unable to read answer file (./code).");
        }

        $this->raw = $content;
        $this->parser = new Parser($content);
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
        return new Analyzer(self::ANSWER_FILE_PATH);
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
