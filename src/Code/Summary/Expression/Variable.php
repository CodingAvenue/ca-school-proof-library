<?php

namespace CodingAvenue\Proof\Code\Summary\Expression;

use PhpParser\Node\Expr;
use CodingAvenue\Proof\Code\Summary\Expression;

class Variable extends Expression {
    public function __construct(Expr $expr)
    {
        $this->type = 'variable';
        $this->type = $expr->name;
    }
}