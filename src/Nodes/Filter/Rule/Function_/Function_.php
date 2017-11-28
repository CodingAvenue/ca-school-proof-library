<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Function_;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Function_ extends Rule implements RuleInterface
{
    const CLASS_ = '\PhpParser\Node\Stmt\Function_';

    public function getRule(): callable
    {
        $class = self::CLASS_;
        $filter = $this->filter;
        $paramByRefs = function($node, $filter) {
            $isByRefs = true;
    
            if (isset($filter['paramsByRefs'])) {
                $byRefs = $filter['paramsByRefs'];                
                $paramsRef = array_map('trim', explode(',', $byRefs));
    
                foreach ($paramsRef as $param) {
                    foreach ($node->params as $nodeParam) {
                        if ($nodeParam->name->name === $param) {
                            if (!$nodeParam->byRef) {
                                $isByRefs = false;
                                break 2;
                            }
                        }
                    }
                }
            }
    
            return $isByRefs;
        };

        return function($node) use ($class, $filter, $paramByRefs) {
            return (
                $node instanceof $class
                && (isset($filter['name']) ? $node->name === $filter['name'] : true)
                && $paramByRefs($node, $filter)
            );
        };
    }

    public function allowedOptionalFilter()
    {
        return array('name', 'paramsByRefs');
    }
}
