<?php

namespace CodingAvenue\Proof\Code;

class NodeFinder
{
    /**
     * @var array of operators - An array of php operators mapped to it's NodeFinder class.
     */
    private static $operators = [
        "assignment"    => __NAMESPACE__ . "\NodeFinder\AssignmentFinder",
        "echo"          => __NAMESPACE__ . "\NodeFinder\EchoFinder",
        "addition"      => __NAMESPACE__ . "\NodeFinder\AdditionFinder"
    ];

    /**
     * @var array of constructs - An array of php language constructs mapped to it's NodeFinder class.
     */
    private static $constructs = [

    ];

    /**
     * @var array of functions - An array of php build in functions mapped to it's NodeFinder class.
     */
    private $builtInFunctions = [

    ];

    /**
     * Finds all variable nodes, can be filtered by the name of a variable.
     *
     * @param array $nodes The nodes to be searched.
     * @param array $filter An optional array with a 'name' key that will be used to filter the variable namespace
     * @return array of variable nodes.
     */
    public function findVariable(array $nodes, $filter = null): array
    {
        if(!is_null($filter) && !isset($filter['name'])) {
            throw new \Exception("A 'name' key is required for filtering a variable.");
        }

        $finder = new NodeFinder\VariableFinder($nodes, $filter);
        return $finder->find();
    }

    /**
     * Finds all Variable interpolation nodes
     *
     * To check if a given variable name is used on the interpolation you will have to call
     * findVariable with the given variable name and verify the result.
     *
     * @param array $nodes The nodes to be searched.
     * @return array of Encapsed nodes.
     */
    public function findEncapsed(array $nodes): array
    {
        $finder = new NodeFinder\EncapsedFinder($nodes);
        return $finder->find();
    }

    /**
     * Finds all String literals that was used together with a variable on a variable interpolation.
     *
     * @param array $nodes The nodes to be searched.
     * @return array of EncapsedString nodes.
     */
    public function findEncapsedString(array $nodes): array
    {
        $finder = new NodeFinder\EncapsedStringFinder($nodes);
        return $finder->find();
    }

    /**
     * Finds all operators node filtered by a given operator name.
     *
     * @param array $nodes the nodes to be searched.
     * @param array $filter the filter to be used on the searched.
     * @return array of the operator nodes.
     */
    public function findOperator($nodes, $filter): array
    {
        $operatorFinder = self::$operators[$filter['name']];
        
        if (!$operatorFinder) {
            throw new \Exception("Unknown operator name {$filter['name']}");
        }

        unset($filter['name']);

        $finder = new $operatorFinder($nodes, $filter);
        return $finder->find();
    }

    /**
     * Find all built-in function nodes filtered by a given built-in function name.
     *
     * @param array $nodes the nodes to be searched.
     * @param array $filter the filter to be used on the searched.
     * @return array of buildin function nodes.
     */
    public function findBuiltInFunction($nodes, $filter): array
    {
        $functionFinder = self::$buildInFunctions[$filter['name']];

        if(!$functionFinder) {
            throw new \Exception("Unknown built-in function name {$filter['name']}");
        }

        unset($filter['name']);

        $finder = new $functionFinder($nodes, $filter);
        return $finder->find();
    }

    /**
     * Find all function nodes filtered by a function name.
     *
     * @param array $nodes the nodes to be searched
     * @param array $filter the filter to be used on the searched
     * @return array of function nodes. This would return 0 or 1 element array
     */
    public function findFunction($nodes, $filter): array
    {
        $finder = new NodeFinder\FunctionFinder($nodes, $filter);
        return $finder->find();
    }

    /**
     * Find all language constructs filtered by a function name.
     *
     * @param array $nodes the nodes to be searched
     * @param array $filter the filter to be used on the searched
     * @return array of construct nodes.
     */
    public function findConstructs($nodes, $filter): array
    {
        $constructFinder = self::$constructs[$filter['name']];

        if(!$constructFinder) {
            throw new \Exception("Unknown constructs {$filter['name']}");
        }

        unset($filter['name']);

        $finder = new $constructFinder($nodes, $filter);
        return $finder->find();
    }
}
