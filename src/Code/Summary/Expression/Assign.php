<?php

namespace CodingAvenue\Proof\Code\Summary\Expression;

use PhpParser\Node\Expr;
use CodingAvenue\Proof\Code\Summary\Expression;
use CodingAvenue\Proof\Code\Summary\ExpressionFactory;

class Assign extends Expression {
    public function __construct(Expr $expr)
    {
        $this->type = 'assignment';

        $var = ExpressionFactory::create($expr->var);
        $assignmentExpr = ExpressionFactory::create($expr->expr);

        $this->value = [
            'variable' => ['type' => $var->getType(), 'value' => $var->getValue()],
            'value' => ['type' => $assignmentExpr->getType(), 'value' => $assignmentExpr->getValue()]
        ];
    }
}
