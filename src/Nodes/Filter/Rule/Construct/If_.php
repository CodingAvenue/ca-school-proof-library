<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Construct;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class If_ extends Rule implements RuleInterface
{
    const CLASS_ = '\PhpParser\Node\Stmt\If_';

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
                    isset($filter['hasElseIfs'])
                        ? $filter['hasElseIfs'] === true
                            ? count($node->elseifs) > 0
                            : count($node->elseifs) === 0
                        : true
                )
                && (
                    isset($filter['hasElse'])
                        ? $filter['hasElse'] === true
                            ? !is_null($node->else)
                            : is_null($node->else)
                        : true
                )
            );
        };
    }

    public function allowedOptionalFilter()
    {
        return array('hasElseIfs', 'hasElse');
    }
}
