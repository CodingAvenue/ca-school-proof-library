<?php

namespace CodingAvenue\Proof\Code;

use PhpParser\ParserFactory;
use CodingAvenue\Proof\InvalidCodeError;

class Parser
{
    private $nodes;

    public function __construct(string $code)
    {
        $parser = (new ParserFactory())->create(ParserFactory::PREFER_PHP7);
        try {
            $this->nodes = $parser->parse($code);
        } catch (Error $e) {
            throw new InvalidCodeError($e->getMessage());
        }
    }

    public function getNodes(): array
    {
        return $this->nodes;
    }
}
