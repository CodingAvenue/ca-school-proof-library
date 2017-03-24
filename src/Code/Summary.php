<?php

namespace CodingAvenue\Proof\Code;

class Summary
{
    private $summary;

    public function __construct($summary)
    {
        $this->summary = $summary;
    }

    public function getSummary(): array
    {
        return $this->summary;
    }

    public function getAllFunctions(): array
    {
        return $this->summary['functions'];
    }

    public function getFunction(string $name): array
    {
        return array_value(
            array_filter(function($function) use ($name) {
                return ($function['name'] === $name);
            }, $this->summary['functions'])
        );
    }

    public function getAllVariables(): array
    {
        return $this->summary['variables'];
    }

    public function getVariable(string $name): string
    {
        return (array_value(
            array_filter(function($variable) use ($name) {
                return ($variable === $name);
            }, $this->summary['variables'])
        ))[0];
    }

    public function getAllOperators(): array
    {
        return $this->summary['operators'];
    }

    public function getOperator(string $name): array
    {
        return array_value(
            array_filter(function($operator) use ($name) {
                return ($operator['type'] === $name);
            }, $this->summary['operators'])
        );
    }
}