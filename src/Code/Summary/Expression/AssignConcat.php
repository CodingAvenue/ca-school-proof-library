<?php

namespace CodingAvenue\Proof\Code\Summary\Expression;

use PhpParser\Node\Expr;
use CodingAvenue\Proof\Code\Summary\Expression;
use CodingAvenue\Proof\Code\Summary\ExpressionFactory;

class AssignConcat extends Expression {
    public function __construct(Expr $expr)
    {
        $this->type = 'assignment_concatenation';

        $assignExpr = ExpressionFactory::create($expr->expr);
        $this->value = ['type' => $assignExpr->getType(), 'value' => $assignExpr->getValue()];
    }
}
