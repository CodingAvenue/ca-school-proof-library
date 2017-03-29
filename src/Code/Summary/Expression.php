<?php

namespace CodingAvenue\Proof\Code\Summary;

abstract class Expression
{
    protected $type;
    protected $value;

    public function getType()
    {
        return $this->type;
    }

    public function getValue()
    {
        return $this->value;
    }
}