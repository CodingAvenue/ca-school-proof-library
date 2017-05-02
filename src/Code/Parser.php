<?php

namespace CodingAvenue\Proof\Code;

use PhpParser\ParserFactory;
use CodingAvenue\Proof\InvalidCodeError;

class Parser
{
    public static function parse(string $code)
    {
        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
        try {
            return $parser->parse($code);
        } catch (Error $e) {
            throw new InvalidCodeError($e->getMessage());
        }
    }
}
