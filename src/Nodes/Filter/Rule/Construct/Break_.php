<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Construct;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Break_ extends Rule implements RuleInterface
{
    const CLASS_ = '\PhpParser\Node\Stmt\Break_';

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
                    isset($filter['hasArg'])
                        ? $filter['hasArg'] === true
                            ? !is_null($node->num)
                            : is_null($node->num)
                        : true
                )
            );
        };
    }

    public function allowedOptionalFilter()
    {
        return array('hasArg');
    }
}
