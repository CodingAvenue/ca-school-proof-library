<?php

namespace CodingAvenue\Proof\Code\Summary\Expression;

use PhpParser\Node\Expr;
use CodingAvenue\Proof\Code\Summary\Expression;
use CodingAvenue\Proof\Code\Summary\ExpressionFactory;

class ArrayDimFetch extends Expression {
    public function __construct(Expr $expr)
    {
        $this->type = 'array_fetch_element';

        $var = ExpressionFactory::create($expr->var);
        $key = ExpressionFactory::create($expr->dim);

        $this->value = [
            'var' => ['type' => $var->getType(), 'value' => $var->getValue()],
            'key' => ['type' => $key->getType(), 'value' => $key->getValue()]
        ];
    }
}
