<?php

namespace CodingAvenue\Proof\Nodes\Filter;

/**
 * Factory class for the Filter class
 * Maps a filter name to it's Filter class
 * Returns the instance of that Filter class.
 * throws an Exception if no filter is found
 */
class FilterFactory
{
    /**
     * Main factory method, given the name returns the instance of the Filter class that correspond to that name
     *
     * @param string $name the name of the filter
     * @param array $attributes the attributes to be passed to the Filter constructor
     * @param bool $traverse if this Filter will be applied to it's children only or not
     *
     * @return the instance of the Filter found
     * @throws Exception if no Filter class is found.
     */
    public static function createFilter(string $name, array $attributes, bool $traverse)
    {
        $filters = self::getFilters();

        $filter = isset($filters[$name]) ? $filters[$name] : null;
        if (is_null($filter)) {
            throw new \Exception("No Filter class found to handle {$name}");
        }

        return new $filter($name, $attributes, $traverse);
    }

    public static function getFilters()
    {
        return array(
            'operator'      => "\CodingAvenue\Proof\Nodes\Filter\Operator",
            'variable'      => "\CodingAvenue\Proof\Nodes\Filter\Variable",
            'interpolation' => "\CodingAvenue\Proof\Nodes\Filter\Interpolation",
            'datatype'      => "\CodingAvenue\Proof\Nodes\Filter\Datatype",
            'construct'     => "\CodingAvenue\Proof\Nodes\Filter\Construct",
            'function'      => "\CodingAvenue\Proof\Nodes\Filter\Function_",
            'call'          => "\CodingAvenue\Proof\Nodes\Filter\Call",
            'anonymous'     => "\CodingAvenue\Proof\Nodes\Filter\Anonymous",
            'class'         => "\CodingAvenue\Proof\Nodes\Filter\Class_",
            'use'           => "\CodingAvenue\Proof\Nodes\Filter\Use_",
            'namespace'     => "\CodingAvenue\Proof\Nodes\Filter\Namespace_",
            'interface'     => "\CodingAvenue\Proof\Nodes\Filter\Interface_",
            'method'        => "\CodingAvenue\Proof\Nodes\Filter\Method_",
            'const'         => "\CodingAvenue\Proof\Nodes\Filter\Const_",
            'const-fetch'   => "\CodingAvenue\Proof\Nodes\Filter\ConstFetch",
            'static-prop-fetch' => "\CodingAvenue\Proof\Nodes\Filter\StaticPropFetch",
            'static-call'   => "\CodingAvenue\Proof\Nodes\Filter\StaticCall",
            'property'      => "\CodingAvenue\Proof\Nodes\Filter\Property_",
            'property-call' => "\CodingAvenue\Proof\Nodes\Filter\PropertyCall",
            'instantiate'   => "\CodingAvenue\Proof\Nodes\Filter\Instantiate_",
            'method-call'   => "\CodingAvenue\Proof\Nodes\Filter\MethodCall",
            'param'         => "\CodingAvenue\Proof\Nodes\Filter\Param_",
            'args'          => "\CodingAvenue\Proof\Nodes\Filter\Args_",
            'assign-ref'    => "\CodingAvenue\Proof\Nodes\Filter\AssignRef",
            'include'       => "\CodingAvenue\Proof\Nodes\Filter\Include_",
            'string'        => "\CodingAvenue\Proof\Nodes\Filter\String_",
            'integer'       => "\CodingAvenue\Proof\Nodes\Filter\Integer_",
            'float'         => "\CodingAvenue\Proof\Nodes\Filter\Float_"
        );
    }
}
