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
            'call'          => "\CodingAvenue\Proof\Nodes\Filter\Call"
        );
    }
}
