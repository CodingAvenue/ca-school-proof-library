<?php

namespace CodingAvenue\Proof\Nodes\Filter;

class FilterFactory
{
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
            'construct'     => "\CodingAvenue\Proof\Nodes\Filter\Construct"
        );
    }
}
