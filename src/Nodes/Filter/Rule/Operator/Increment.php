<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule\Operator;

use CodingAvenue\Proof\Nodes\Filter\Rule\Rule;
use CodingAvenue\Proof\Nodes\Filter\Rule\RuleInterface;

class Increment extends Rule implements RuleInterface
{
    const POST_CLASS_ = '\PhpParser\Node\Expr\PostInc';
    const PRE_CLASS_ = '\PhpParser\Node\Expr\PreInc';

    public function getRule(): callable
    {
        $post = self::POST_CLASS_;
        $pre = self::PRE_CLASS_;
        $filter = $this->filter;

        $this->checkType();

        return function($node) use ($post, $pre, $filter) {
            return (
                (
                    isset($filter['type'])
                        ? $filter['type'] == 'pre'
                            ? $node instanceof $pre
                            : $node instanceof $post
                        : ($node instanceof $pre || $node instanceof $post)
                )
                &&
                (
                    isset($filter['variable'])
                        ? $filter['variable'] == $node->var->name
                        : true
                )
            );
        };
    }

    public function checkType()
    {
        if (isset($this->filter['type'])) {
            $type = $this->filter['type'];
            if ($type !== 'pre' && $type !== 'post') {
                throw new \Exception("Unknown type '{$type}'. Supported type is 'pre' and 'post'");
            }
        }
    }

    public function allowedOptionalFilter()
    {
        return array('variable', 'type');
    }
}