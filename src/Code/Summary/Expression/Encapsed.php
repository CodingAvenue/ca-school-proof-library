<?php

namespace CodingAvenue\Proof\Code\Summary\Expression;

use PhpParser\Node\Expr;
use CodingAvenue\Proof\Code\Summary\Expression;
use CodingAvenue\Proof\Code\Summary\ExpressionFactory;

class Encapsed extends Expression{
    public function __construct(Expr $expr)
    {
        $this->type = 'interpolation';
        $this->value = [];

        foreach ($expr->parts as $part) {
            if ($part instanceof Expr) {
                $partExpr = ExpressionFactory::create($part);
                $this->value[] = ['type' => $partExpr->getType(), 'value' => $partExpr->getValue()];
            }
        }
    }
}