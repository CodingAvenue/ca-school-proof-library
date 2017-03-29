<?php

namespace CodingAvenue\Proof\Code\Summary\Expression;

use PhpParser\Node\Expr;

class EncapsedStringPart extends ScalarExpression {
    public function __construct(Expr $expr)
    {
        parent::__construct($expr);
    }
}
