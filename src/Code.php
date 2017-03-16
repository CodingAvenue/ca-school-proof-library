<?php

namespace CodingAvenue\Proof;

/**
 * @author Sandae P. Macalalag <sandaemc@gmail.com>
 */
class Code {

    const ANSWER_FILE_PATH = './code';

    private $raw;
    private $parsed;

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
        $this->parsed = new ParsedCode($content);
    }

    public function parser()
    {
        return $this->parsed;
    }

    public function __toString()
    {
        return $this->raw;
    }

    public function analyzer()
    {
        return new Analyzer(self::ANSWER_FILE_PATH);
    }
}
