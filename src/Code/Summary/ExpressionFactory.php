<?php

namespace CodingAvenue\Proof\Code\Summary;

use PhpParser\Node\Expr;

class ExpressionFactory {
    /**
     * Create an instance of CodingAvenue\Proof\Code\Summary\Expression subclass.
     * The subclass name is identical to PhpParser\Node\Expr\ subclasses.
     *
     * @param PhpParser\Node\Expr $expr - an instance of PhpParser Expr class.
     * @return An instance of a subclass from CodingAvenue\Proof\Code\Summary\Expression.
     */
    public function create(Expr $expr)
    {
        $className = get_class($expr);

        // Concat class name is used on BinaryOp and AssignOp namespace. We'll need to change their classname mapping to avoid conflict.
        if ($className === 'PhpParser\Node\Expr\BinaryOp\Concat') {
            $className = 'BinaryConcat';
        }
        elseif ($className === 'PhpParser\Node\Expr\AssignOp\Concat') {
            $className === 'AssignConcat';
        }
        else {
            $className = str_replace("\\", ucwords($className));
        }

        // Appending the Expression part so can avoid a very large use statement.
        $className = "Expression\$className";

        return new $className($expr);
    }
}