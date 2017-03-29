<?php

namespace CodingAvenue\Proof\Code\Summary\Expression;

use PhpParser\Node\Expr;
use CodingAvenue\Proof\Code\Summary\Expression;
use CodingAvenue\Proof\Code\Summary\ExpressionFactory;

class ArrayItem extends Expression {
    public function __construct(Expr $expr)
    {
        $this->type = 'array_element';

        //if $expr->key is an instance of Expr then it's an associative array.

        if ($expr->key instanceof Expr) {
            $key = ExpressionFactory::create($expr->key);
        }

        $value = ExpressionFactory::create($expr->value);

        $this->value = [
            'key' => $key ? ['type' => $key->getType(), 'value' => $key->getValue()] : null,
            'value' => ['type' => $value->getType(), 'value' => $value->getValue()]
        ];
    }
}
