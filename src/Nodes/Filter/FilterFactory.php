<?php

namespace CodingAvenue\Proof\Nodes\Filter;

class FilterFactory
{
    public static function createFilter(string $name, array $attributes, bool $traverse)
    {
        $class = __NAMESPACE__ . "\\" . ucfirst($name);
        if (!class_exists($class)) {
            throw new \Exception("Unknown Filter class {$name}");
        }

        return new $class($name, $attributes, $traverse);
    }
}
