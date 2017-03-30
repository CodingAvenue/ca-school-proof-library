<?php

namespace CodingAvenue\Proof\Code;

class NodeFinder
{
    /**
     * @var array of operators An array of php operators mapped to it's NodeFinder class.
     * I'm not sure if operators is the correct term for this one. Since some of it are not operators but more of a construct?
     * But some construct are interchangeble also called as operators E.g. the logical operator 'or' is a construct also.
     */
    protected $operators = [
        "assignment"    => __NAMESPACE__ . "\NodeFinder\AssignmentFinder",
        "echo"          => __NAMESPACE__ . "\NodeFinder\EchoFinder",
        "addition"      => __NAMESPACE__ . "\NodeFinder\AdditionFinder"
    ];

    /**
     * @var array of functions - An array of php build in functions mapped to it's NodeFinder class.
     */
    protected $functions = [

    ];

    public function findVariable(array $nodes, $filter = null): array
    {
        if(!is_null($filter) && !isset($filter['name'])) {
            throw new \Exception("A 'name' key is required for filtering a variable.");
        }

        $finder = new NodeFinder\VariableFinder($nodes, $filter);
        return $finder->find();
    }

    public function findEncapsed(array $nodes): array
    {
        $finder = new NodeFinder\EncapsedFinder($nodes);
        return $finder->find();
    }

    public function findEncapsedString(array $nodes): array
    {
        $finder = new NodeFinder\EncapsedStringFinder($nodes);
        return $finder->find();
    }

    public function findOperator($nodes, $filter): array
    {
        $operatorFinder = $this->operators[$filter['name']];
        
        if (!$operatorFinder) {
            throw new \Exception("Unknown operator name {$filter['name']}");
        }

        unset($filter['name']);

        $finder = new $operatorFinder($nodes, $filter);
        return $finder->find();
    }

    public function findBuiltInFunction($nodes, $filter): array
    {
        $functionFinder = $this->functions[$filter['name']];

        if(!$functionFinder) {
            throw new \Exception("Unknown built-in function name {$filter['name']}");
        }

        unset($filter['name']);

        $finder = new $functionFinder($nodes, $filter);
        return $finder->find();
    }

    public function findFunction($nodes, $filter): array
    {
        $finder = new NodeFinder\FunctionFinder($nodes, $filter);
        return $finder->find();
    }
}
