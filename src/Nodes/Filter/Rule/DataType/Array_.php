<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\DataType;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Array_ extends Rule implements RuleInterface
{
    const CLASS_ = '\PhpParser\Node\Expr\Array_';

    public function getRule(): callable
    {
        $class = self::CLASS_;

        $type = $this->getFilterType();
        $stringClass = 'PhpParser\Node\Scalar\String_';

        return function($node) use ($class, $type, $stringClass) {
            return (
                $node instanceof $class
                && (
                    !is_null($type)
                        ? ($type === 'associative' ? !is_null($node->items[0]->key) : is_null($node->items[0]->key))
                        : true
                )
            );
        };
    }

    public function getFilterType()
    {
        if (isset($this->filter['type'])) {
            if($this->filter['type'] === 'associative' || $this->filter['type'] === 'indexed') {
                return $this->filter['type'];
            }

            throw new \Exception("Unknown Array Type {$this->filter['type']}.");
        }

        return null;
    }

    public function allowedOptionalFilter()
    {
        return array('type');
    }
}
