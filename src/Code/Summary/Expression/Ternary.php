<?php

namespace CodingAvenue\Proof\Code\Summary\Expression;

use PhpParser\Node\Expr;
use CodingAvenue\Proof\Code\Summary\Expression;
use CodingAvenue\Proof\Code\Summary\ExpressionFactory;

class AssignConcat extends Expression {
    public function __construct(Expr $expr)
    {
        $this->type = 'ternary';

        if($expr->cond instanceof Expr) {
            $condExpr = ExpressionFactory::create($expr->cond);
            $cond = ['type' => $condExpr->getType(), 'value' => $condExpr->getValue()];
        }
        if ($expr->if instanceof Expr) {
            $ifExpr = ExpressionFactory::create($expr->if);
            $if = ['type' => $ifExpr->getType(), 'value' => $ifExpr->getValue()];
        }

        if ($expr->else instanceof Expr) {
            $elseExpr = ExpressionFactory::create($expr->else);
            $else = ['type' => $elseExpr->getType(), 'value' => $elseExpr->getValue()];
        }

        $this->value = ['cond' => $cond, 'if' => $if, 'else' => $else];
    }
}
