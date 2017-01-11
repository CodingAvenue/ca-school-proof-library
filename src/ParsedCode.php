<?php

namespace CodingAvenue\Proof;

use PhpParser\ParserFactory;
use PhpParser\Error;

class ParsedCode 
{
    private $parsed;

    public function __construct()
    {
        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);

        try {
            $this->parsed = $parser->parse((new Code())->__toString());
        } catch (Error $e) {
            throw new InvalidCodeError($e->getMessage());
        }
    }

    public function getStatements()
    {
        return $this->parsed;
    }
}
