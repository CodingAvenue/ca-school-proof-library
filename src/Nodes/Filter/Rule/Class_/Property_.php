<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Class_;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Property_ extends Rule implements RuleInterface
{
    const CLASS_ = 'PhpParser\Node\Stmt\Property';

    public function getRule(): callable
    {
        $class = self::CLASS_;
        $filter = $this->filter;
        $propTypes = $this->propertyTypes();

        return function($node) use ($class, $filter, $propTypes) {
            return (
                ($node instanceof $class) &&
                (isset($filter['name']) ? $node->props[0]->name === $filter['name'] : true) &&
                (isset($filter['type'])
                    ? $propTypes($filter['type'], $node)
                    : true
                )
            );
        };
    }

    public function allowedOptionalFilter()
    {
        return array('name', 'type');
    }

    private function propertyTypes()
    {
        return function($type, $node) {
            switch ($type) {
                case 'public':
                    return $node->isPublic();
                    break;
                case 'protected':
                    return $node->isProtected();
                    break;
                case 'private':
                    return $node->isPrivate();
                    break;
                case 'static':
                    return $node->isStatic();
                    break;
                default:
                    return false;
                    break;
            }
        };
    }
}
