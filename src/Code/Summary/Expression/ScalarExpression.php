<?php

namespace CodingAvenue\Proof\Code\Summary\Expresion;

use PhpParser\Node\Expr;
use CodingAvenue\Proof\Code\Summary\Expression;

class ScalarExpression extends Expression {
    public function __construct(Expr $expr)
    {
        $this->type = 'scalar';
        $this->value = $expr->value;
    }
}