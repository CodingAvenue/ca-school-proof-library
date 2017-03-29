<?php

namespace CodingAvenue\Proof\Code\Summary\Expression;

use PhpParser\Node\Expr;
use CodingAvenue\Proof\Code\Summary\Expression;
use CodingAvenue\Proof\Code\Summary\ExpressionFactory;

class BinaryConcat extends Expression {
    public function __construct(Expr $expr)
    {
        $this->type = 'concatenation';

        if($expr->left instanceof Expr) {
            $left = ExpressionFactory::create($expr->left);
        }

        if($expr->right instanceof Expr) {
            $right = ExpressionFactory::create($expr->right);
        }

        $this->value = [
            'left'  => ['type' => $left->getType(), 'value' => $left->getValue()],
            'right' => ['type' => $right->getType(), 'value' => $right->getValue()]
        ];
    }
}