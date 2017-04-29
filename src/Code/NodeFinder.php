<?php

namespace CodingAvenue\Proof\Code;

use CodingAvenue\Proof\Code\NodesFilter;
use CodingAvenue\Proof\Code\PseudoFilter;

class NodeFinder
{
    /**
     * @var array of operators - An array of php operators mapped to it's NodeFinder class.
     */
    private static $operators = array(
        "assignment"        => __NAMESPACE__ . "\NodeFinder\Operator\AssignmentFinder",
        "concat"            => __NAMESPACE__ . "\NodeFinder\Operator\String\BinaryConcatFinder",
        "assign-concat"     => __NAMESPACE__ . "\NodeFinder\Operator\String\AssignConcatFinder",
        "addition"          => __NAMESPACE__ . "\NodeFinder\Operator\Arithmetic\AdditionFinder",
        "subtraction"       => __NAMESPACE__ . "\NodeFinder\Operator\Arithmetic\SubtractionFinder",
        "multiplication"    => __NAMESPACE__ . "\NodeFinder\Operator\Arithmetic\MultiplicationFinder",
        "division"          => __NAMESPACE__ . "\NodeFinder\Operator\Arithmetic\DivisionFinder",
        "modulo"            => __NAMESPACE__ . "\NodeFinder\Operator\Arithmetic\ModuloFinder",
        "pow"               => __NAMESPACE__ . "\NodeFinder\Operator\Arithmetic\PowFinder",
        "equal"             => __NAMESPACE__ . "\NodeFinder\Operator\Comparison\EqualFinder",
        "identical"         => __NAMESPACE__ . "\NodeFinder\Operator\Comparison\IdenticalFinder",
        "not-equal"         => __NAMESPACE__ . "\NodeFinder\Operator\Comparison\NotEqualFinder",
        "not-identical"     => __NAMESPACE__ . "\NodeFinder\Operator\Comparison\NotIdenticalFinder",
        "greater"           => __NAMESPACE__ . "\NodeFinder\Operator\Comparison\GreaterFinder",
        "less"              => __NAMESPACE__ . "\NodeFinder\Operator\Comparison\LessFinder",
        "less-equal"        => __NAMESPACE__ . "\NodeFinder\Operator\Comparison\LessEqualFinder",
        "greater-equal"     => __NAMESPACE__ . "\NodeFinder\Operator\Comparison\GreaterEqualFinder",
        "spaceship"         => __NAMESPACE__ . "\NodeFinder\Operator\Comparison\SpaceshipFinder",
    );

    private static $dataTypes = array(
        "string"            => __NAMESPACE__ . "\NodeFinder\DataType\StringFinder",
        "array"             => __NAMESPACE__ . "\NodeFinder\DataType\ArrayFinder"
    );

    /**
     * @var array of constructs - An array of php language constructs mapped to it's NodeFinder class.
     */
    private static $constructs = array(
        "echo"          => __NAMESPACE__ . "\NodeFinder\Construct\EchoFinder"
    );

    /**
     * Apply a NodeFilter instance into the array of nodes.
     *
     * @param NodeFilter the filter to be applied
     * @param array of nodes the nodes to be filtered
     *
     * @return array of nodes that has been filtered
     */
    public function applyFilter(NodesFilter $filter, array $nodes): array
    {
        if ($filter->hasAction()) {
            $method = $filter->getAction();
            if (!method_exists($this, $method)) {
                throw new \Exception("Unknown method $method for NodeFinder class.");
            }

            $nodes = $this->$method($nodes, $filter->getParams(), $filter->getTraverseChildren());
        }

        if (empty($nodes)) {
            return $nodes;
        }

        $pseudoFilter = new PseudoFilter($filter->getPseudo());
        $nodes = $pseudoFilter->filter($nodes);

        return $nodes;
    }

    /**
     * Finds all variable nodes, can be filtered by the name of a variable.
     *
     * @param array $nodes The nodes to be searched.
     * @param array $filter An optional array with a 'name' key that will be used to filter the variable name
     * @return array of variable nodes.
     */
    public function findVariable(array $nodes, $filter = array(), $traverseChildren = true): array
    {
        $finder = new NodeFinder\Variable\VariableFinder($nodes, $filter, $traverseChildren);
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
        $finder = new NodeFinder\Variable\EncapsedFinder($nodes, $filter, $traverseChildren);
        return $finder->find();
    }

    /**
     * TODO This will be remove in the future
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
     * Find all function nodes filtered by a function name.
     *
     * @param array $nodes the nodes to be searched
     * @param array $filter the filter to be used on the searched
     * @return array of function nodes. This would return 0 or 1 element array
     */
    public function findFunction($nodes, $filter, $traverseChildren = true): array
    {
        $finder = new NodeFinder\Function_\FunctionFinder($nodes, $filter, $traverseChildren);
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

    public function findCall($nodes, $filter, $traverseChildren = true): array
    {
        $finder = new NodeFinder\Function_\FuncCallFinder($nodes, $filter, $traverseChildren);
        return $finder->find();
    }

    public function findDatatype($nodes, $filter, $traverseChildren = true): array
    {
        if (!array_key_exists($filter['name'], self::$dataTypes)) {
            throw new \Exception("Unknown data type " . $filter['name'] . ". Supported Data Types are [" . implode(",", array_keys(self::$dataTypes)) . "]");
        }

        $dataTypeFinder = self::$dataTypes[$filter['name']];

        unset($filter['name']);

        $finder = new $dataTypeFinder($nodes, $filter, $traverseChildren);
        return $finder->find();
    }

    public function findArrayfetch($nodes, $filter, $traverseChildren = true): array
    {
        $finder = new NodeFinder\DataType\ArrayFetchFinder($nodes, $filter, $traverseChildren);
        return $finder->find();
    }
}
