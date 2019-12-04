<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Class_;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Class_ extends Rule implements RuleInterface
{
    const CLASS_ = 'PhpParser\Node\Stmt\Class_';

    public function getRule(): callable
    {
        $class = self::CLASS_;
        $filter = $this->filter;
        $classTypes = $this->classTypes();

        return function($node) use ($class, $filter, $classTypes) {
            return (
                ($node instanceof $class) &&
                (isset($filter['name']) ? $node->name === $filter['name'] : true) &&
                (isset($filter['extends']) ? $node->extends->parts[0] === $filter['extends'] : true) &&
                (isset($filter['interface']) 
                    ? count(
                            array_filter(
                                $node->implements, function($k) use ($filter) {
                                    return $k->parts[0] === $filter['interface'];
                                }
                            )
                        ) > 0
                    : true
                ) &&
                (isset($filter['type'])
                    ? $classTypes($filter['type'], $node)
                    : true
                )
            );
        };
    }

    public function allowedOptionalFilter()
    {
        return array('name', 'extends', 'interface', 'type');
    }

    private function classTypes()
    {
        return function($type, $node) {
            switch ($type) {
                case 'abstract':
                    return $node->isAbstract();
                    break;
                case 'final':
                    return $node->isFinal();
                    break;
                default:
                    return false;
                    break;
            }
        };
    }
}
