<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\DataType;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Integer_ extends Rule implements RuleInterface
{
    const CLASS_ = '\PhpParser\Node\Scalar\LNumber';
    private $types = array(
        'binary'    => 2,
        'octal'     => 8,
        'decimal'   => 10,
        'hex'       => 16
    );

    public function getRule(): callable
    {
        $class = self::CLASS_;
        $filter = $this->filter;

        $kind = $this->getKindType($filter);
        
        return function($node) use ($class, $filter, $kind) {
            return (
                $node instanceof $class
                && (isset($filter['value']) ? $node->value === $filter['value'] : true)
                && (!is_null($kind) ? $node->getAttribute('kind') == $kind : true)
            );
        };
    }

    public function getKindType()
    {
        if(isset($this->filter['type'])) {
            if (array_key_exists($this->filter['type'], $this->types)) {
                return $this->types[$this->filter['type']];
            }

            throw new \Exception("Unknown type {$this->filter['type']}. Supported types are " . implode(', ', array_keys($this->types)));
        }

        return null;
    }

    public function allowedOptionalFilter()
    {
        return array('value', 'type');
    }
}
