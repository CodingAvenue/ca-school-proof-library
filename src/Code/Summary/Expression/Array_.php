<?php

namespace CodingAvenue\Proof\Code\Summary\Expression;

use PhpParser\Node\Expr;
use CodingAvenue\Proof\Code\Summary\Expression;
use CodingAvenue\Proof\Code\Summary\ExpressionFactory;

class Array_ extends Expression {
    public function __construct(Expr $expr)
    {
        $this->type = 'array';

        $items = [];
        foreach ($expr->items as $item) {
            $arrayItem = ExpressionFactory::create($item);
            $items[] = ['type' => $arrayItem->getType(), 'value' => $arrayItem->getValue()];
        }

        $this->value = $items;
    }
}
