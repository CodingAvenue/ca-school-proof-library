<?php

namespace CodingAvenue\Proof\Code;

use PhpParser\Node\Scalar;
use PhpParser\Node\Expr;
use PhpParser\Node\Expr\{
    Variable,
    Assign,
    FuncCall
};

use PhpParser\Node\Stmt\{
    Function_,
    Class_,
    Echo_
};

use CodingAvenue\Proof\Code\Summary;
use CodingAvenue\Proof\Code\SummaryFactory\Expression;

class SummaryFactory
{
    private $nodes;

    public function __construct(array $nodes)
    {
        $this->nodes = $nodes;
    }

    public function create(): Summary
    {
        return new Summary($this->start($this->nodes));
    }

    protected function start(array $nodes, $summary = array()): array
    {
        foreach ($nodes as $node) {
            if ($node instanceof Function_) {
                $summary = $this->parseFunction($node, $summary);
            }
            else if ($node instanceof Variable) {
                $summary = $this->parseVariable($node, $summary);
            }
            else if ($node instanceof Class_) {
                $summary = $this->parseClass($node, $summary);
            }
            else if ($node instanceof FuncCall) {
                $summary = $this->parseFuncCall($node, $summary);
            }
            else if ($node instanceof Assign) {
                $summary = $this->parseAssign($node, $summary);
            }
            else if ($node instanceof Echo_) {
                $summary = $this->parseEcho($node, $summary);
            }
        }

        return $summary;
    }

    protected function parseFunction(array $node, array $summary): array
    {
        $params = array_map(function ($param) {
            return ['name' => $param->name, 'default' => $param->default];
        }, $node->params);
        
        $summary = $this->start($node->stmts, $summary);
        
        array_push($summary['function'], ['name' => $node->name, 'args' => $params, 'stmts' => $node->stmts]); //TODO need to expand $node->stmts

        return $summary;
    }

    protected function parseVariable(array $node, array $summary): array
    {
        if (!in_array($summary['variable'], $node->name)) {
            array_push($summary['variable'], $node->name);
        }

        return $summary;
    }

    protected function parseAssign(array $node, array $summary): array
    {
        if ($node->expr instanceof Expr) {
            $expression = new Expression($node->expr);

            array_push($summary['assign'], ['variable' => $node->var->name, 'type' => $expression->getType(), 'value' => $expression->getValue()]);
            $summary = $this->parseVariable($node->var, $summary);
        }

        return $summary;

        //TODO will need to handle non scalar assignment ops E.g. function calls, ternaries or other operators.
    }

    protected function parseEcho(array $node, array $summary): array
    {
        $args = [];
        foreach($node->exprs as $expr) {
            if ($expr instanceof Expr) {
                $expression = new Expression($expr);
                $args[] = ['type' => $expression->getType(), 'value' => $expression->getValue()];
            }
        }

        array_push($summary['operators']['echo'], $args);

        return $summary;
    }

    protected function parseClass(array $node, array $summary): array
    {
        $implements = array_map(function ($implement) {
            return $implement->parts[0];
        }, $node->implements);  

        array_push($summary['class'], [
            'name' => $node->name,
            'extends' => $node->extends->parts[0],
            'implements' => $mplements//, TODO methods and properties need to be expanded.
            //'methods' => $node->methods,
            //'properties' => [$node->properties]
        ]);

        return $summary;
    }
}