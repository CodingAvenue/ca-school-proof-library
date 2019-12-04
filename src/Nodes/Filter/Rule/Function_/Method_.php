<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Function_;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Method_ extends Rule implements RuleInterface
{
    const CLASS_ = '\PhpParser\Node\Stmt\ClassMethod';

    public function getRule(): callable
    {
        $class = self::CLASS_;
        $filter = $this->filter;
        $methodTypes = $this->methodTypes();

        return function($node) use ($class, $filter, $methodTypes) {
            return (
                $node instanceof $class &&
                (isset($filter['name']) ? $filter['name'] === $node->name : true) &&
                (isset($filter['type'])
                    ? $methodTypes($filter['type'], $node)
                    : true
                )
            );
        };
    }

    public function allowedOptionalFilter()
    {
        return array('name', 'type');
    }

    private function methodTypes()
    {
        return function($type, $node) {
            switch ($type) {
                case 'abstract':
                    return $node->isAbtract();
                    break;
                case 'final':
                    return $node->isFinal();
                    break;
                case 'static':
                    return $node->isStatic();
                    break;
                case 'private':
                    return $node->isPrivate();
                    break;
                case 'protected':
                    return $node->isProtected();
                    break;
                case 'public':
                    return !$node->isProtected() && !$node->isPrivate();
                    break;
                default:
                    return false;
                    break;
            }
        };
    }
}
