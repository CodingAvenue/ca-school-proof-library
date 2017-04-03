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
        "echo"          => __NAMESPACE__ . "\NodeFinder\EchoFinder"
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
    public function findVariable(array $nodes, $filter = array(), $traverseChildren = true): array
    {
        $finder = new NodeFinder\VariableFinder($nodes, $filter, $traverseChildren);
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
    public function findInterpolation(array $nodes, $filter = array(), $traverseChildren = true): array
    {
        $finder = new NodeFinder\EncapsedFinder($nodes, array(), $traverseChildren);
        return $finder->find();
    }

    /**
     * Finds all String literals that was used together with a variable on a variable interpolation.
     *
     * @param array $nodes The nodes to be searched.
     * @return array of EncapsedString nodes.
     */
    public function findEncapsedString(array $nodes, $filter = array(), $traverseChildren = true): array
    {
        $finder = new NodeFinder\EncapsedStringFinder($nodes, array(), $traverseChildren);
        return $finder->find();
    }

    /**
     * Finds all operators node filtered by a given operator name.
     *
     * @param array $nodes the nodes to be searched.
     * @param array $filter the filter to be used on the searched.
     * @return array of the operator nodes.
     */
    public function findOperator($nodes, $filter, $traverseChildren = true): array
    {
        if (!array_key_exists($filter['name'], self::$operators)) {
            throw new \Exception("Unknown operator " . $filter['name'] . ". Supported Operators are [" . implode(",", array_keys(self::$operators)) . "]");
        }

        $operatorFinder = self::$operators[$filter['name']];

        unset($filter['name']);

        $finder = new $operatorFinder($nodes, $filter, $traverseChildren);
        return $finder->find();
        
    }

    /**
     * Find all built-in function nodes filtered by a given built-in function name.
     *
     * @param array $nodes the nodes to be searched.
     * @param array $filter the filter to be used on the searched.
     * @return array of buildin function nodes.
     */
    public function findBuiltInFunction($nodes, $filter, $traverseChildren = true): array
    {
        if (!array_key_exists($filter['name'], self::$builtInFunctions)) {
            throw new \Exception("Unknown built-in function " . $filter['name'] . ". Supported Built-in functions are [" . implode(",", array_keys(self::$builtInFunctions)) . "]");
        }

        $functionFinder = self::$builtInFunctions[$filter['name']];

        unset($filter['name']);

        $finder = new $functionFinder($nodes, $filter, $traverseChildren);
        return $finder->find();
    }

    /**
     * Find all function nodes filtered by a function name.
     *
     * @param array $nodes the nodes to be searched
     * @param array $filter the filter to be used on the searched
     * @return array of function nodes. This would return 0 or 1 element array
     */
    public function findFunction($nodes, $filter, $traverseChildren = true): array
    {
        $finder = new NodeFinder\FunctionFinder($nodes, $filter, $traverseChildren);
        return $finder->find();
    }

    /**
     * Find all language constructs filtered by a function name.
     *
     * @param array $nodes the nodes to be searched
     * @param array $filter the filter to be used on the searched
     * @return array of construct nodes.
     */
    public function findConstruct($nodes, $filter, $traverseChildren = true): array
    {
        if (!array_key_exists($filter['name'], self::$constructs)) {
            throw new \Exception("Unknown language constructs " . $filter['name'] . ". Supported language constructs are [" . implode(",", array_keys(self::$constructs)) . "]");
        }

        $constructFinder = self::$constructs[$filter['name']];

        unset($filter['name']);

        $finder = new $constructFinder($nodes, $filter, $traverseChildren);
        return $finder->find();
    }
}
