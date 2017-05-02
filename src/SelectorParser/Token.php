<?php

namespace CodingAvenue\Proof\SelectorParser;

class Token
{
    /** @var string $type any of the const value */
    private $type;
    /** @var char $value the value of the token */
    private $value;

    public function __construct($type, $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getValue()
    {
        return $this->value;
    }
}
