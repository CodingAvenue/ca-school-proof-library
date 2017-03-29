<?php

namespace CodingAvenue\Proof\Code;

use PhpParser\Node\Expr;
use CodingAvenue\Proof\Code\Summary;
use CodingAvenue\Proof\Code\Summary\ExpressionFactory;

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
            $fullClassName = get_class($node);
            $className = str_replace("\\", ucwords($fullClassName));

            $callMethod = "parse{$className}";

            if(method_exists($this, $callMethod)) {
                $summary = call_user_func_array([$this, $callMethod], [$node, $summary]);
            }
            else {
                throw new \Exception("Unknown method $callMethod. Don't know how to parse class $fullClassName.");
            }
        }

        return $summary;
    }

    protected function parseFunction_(array $node, array $summary): array
    {
        $params = array_map(function ($param) {
            return ['name' => $param->name, 'default' => $param->default];
        }, $node->params);
        
        $summary = $this->start($node->stmts, $summary);
        
        $summary['functions'][] = ['name' => $node->name, 'args' => $params, 'stmts' => $node->stmts]; //TODO need to expand $node->stmts

        return $summary;
    }

    protected function parseVariable(array $node, array $summary): array
    {
        if (!in_array($summary['variable'], $node->name)) {
            $summary['variable'][] = $node->name;
        }

        return $summary;
    }

    protected function parseAssign(array $node, array $summary): array
    {
        if ($node->expr instanceof Expr) {
            // If expr is also another assignment instance we'll have to call parseAssign again. E.g $foo = $bar = 'something';
            if ($node->expr instanceof \PhpParser\Node\Expr\Assign) {
                $summary = $this->parseAssign($node->expr, $summary);
            }

            $expression = ExpressionFactory::create($node->expr);

            $summary['operators']['assignment'][] = ['variable' => $node->var->name, 'type' => $expression->getType(), 'value' => $expression->getValue()];
            $summary = $this->parseVariable($node->var, $summary);
        }

        return $summary;
    }

    protected function parseEcho_(array $node, array $summary): array
    {
        $args = [];
        foreach($node->exprs as $expr) {
            if ($expr instanceof Expr) {
                $expression = ExpressionFactory::create($expr);
                $args[] = ['type' => $expression->getType(), 'value' => $expression->getValue()];
            }
        }

        $summary['constructs']['echo'][] = $args;

        return $summary;
    }

    protected function parseClass_(array $node, array $summary): array
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