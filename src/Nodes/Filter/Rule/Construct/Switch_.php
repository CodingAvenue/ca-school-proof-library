<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Construct;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Switch_ extends Rule implements RuleInterface
{
    const CLASS_ = '\PhpParser\Node\Stmt\Switch_';

    public function __construct(array $filter = array(), bool $traverse = true)
    {
        parent::__construct($filter, $traverse);
        
        foreach ($this->filter as $key => $value) {
            if ($value === 'true') {
                $this->filter[$key] = true;
            }
            elseif ($value === 'false') {
                $this->filter[$key] = false;
            }
            else {
                throw new \Exception("Filter {$key} value must be either 'true' or 'false' but found {$value}.");
            }
        }
    }
    
    public function getRule(): callable
    {
        $class = self::CLASS_;
        $filter = $this->filter;

        return function($node) use ($class, $filter) {
            return (
                $node instanceof $class
                && (
                    isset($filter['hasDefault'])
                        ? $filter['hasDefault'] === true
                            ? count(
                                array_filter($node->cases, function($value) {
                                    return is_null($value->cond);
                                })
                            ) === 1
                            : count(
                                array_filter($node->cases, function($value) {
                                    return is_null($value->cond);
                                })
                            ) === 0
                        : true
                )
            );
        };
    }

    public function allowedOptionalFilter()
    {
        return array('hasDefault');
    }
}
