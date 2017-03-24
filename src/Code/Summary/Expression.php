<?php

namespace CodingAvenue\Proof\Code\Summary;

use PhpParser\Node\Expr;
use PhpParser\Node\Expr\BinaryOp\Concat as BinaryConcat;
use PhpParser\Node\Expr\AssignOp\Concat as AssignConcat;
use PhpParser\Node\Expr\{
    Variable
};

use PhpParser\Node\Scalar\{
    LNumber,
    DNumber,
    String_,
    Encapsed,
    EncapsedStringPart
};

class Expression
{
    private $type;
    private $value;

    public function __construct(Expr $expr)
    {
        $this->__build($expr);
    }

    public function getType()
    {
        return $this->type;
    }

    public function getValue()
    {
        return $this->value;
    }

    private function __build(Expr $expr){
        if ($expr instanceof LNumber || $expr instanceof DNumber || $expr instanceof String_ || $expr instanceof EncapsedStringPart) {
            $this->type = 'scalar';
            $this->value = $expr->value;
        }
        elseif ($expr instanceof Encapsed) {
            $encapsed = [];
            foreach($expr->parts as $part) {
                if ($part instanceof Expr) {
                    $partExpr = new self($part);
                    $encapsed[] = $partExpr->getValue();
                }
            }

            $this->type = 'interpolate';
            $this->value = implode("", $encapsed);
        }
        elseif ($expr instanceof Variable) {
            $this->type = 'variable';
            $this->value = "Variable:" . $expr->name;
        }
        elseif ($expr instanceof BinaryConcat) {
            if ($expr->left instanceof Expr) {
                $left = new self($expr->left);
            }
            if ($expr->right instanceof Expr) {
                $right = new self($expr->right);
            }

            $this->type = 'concatenation';
            $this->value = $left->getValue() . $right->getValue();
        }
        elseif ($expr instanceof AssignConcat) {
            if ($expr->expr instanceof Expr) {
                $assignExpr = new self($expr->expr);
            }

            $this->type = 'assign concatenation';
            $this->value = $assignExpr->getValue();
        }
    }
}