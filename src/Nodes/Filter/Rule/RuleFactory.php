<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule;

class RuleFactory
{
    public static function createRule(string $name, array $filters, bool $traverse)
    {
        $rules = self::getRules();

        $ruleClass = isset($rules[$name]) ? $rules[$name] : null;

        if (is_null($ruleClass)) {
            throw new \Exception("No Rule class to handle rule {$name}");
        }

        return new $ruleClass($filters, $traverse);
    }

    public static function getRules()
    {
        return array(
            'variable'      => "\CodingAvenue\Proof\Nodes\Filter\Rule\Variable\Variable",
            'interpolation' => "\CodingAvenue\Proof\Nodes\Filter\Rule\Variable\Interpolation",
            'assignment'    => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Assignment",
            'concat'        => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\String\Concat",
            'assign-concat' => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\String\AssignConcat",
            'spaceship'     => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\Spaceship",
            'not-identical' => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\NotIdentical",
            'not-equal'     => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\NotEqual",
            'less-equal'    => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\LessEqual",
            'less'          => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\Less",
            'identical'     => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\Identical",
            'greater-equal' => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\GreaterEqual",
            'greater'       => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\Greater",
            'equal'         => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\Equal",
            'subtraction'   => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\Subtraction",
            'pow'           => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\Pow",
            'multiplication' => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\Multiplication",
            'modulo'        => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\Modulo",
            'division'      => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\Division",
            'addition'      => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\Addition",
            'call'          => "\CodingAvenue\Proof\Nodes\Filter\Rule\Function_\Call",
            'function'      => "\CodingAvenue\Proof\Nodes\Filter\Rule\Function_\Function_",
            'string'        => "\CodingAvenue\Proof\Nodes\Filter\Rule\DataType\String_",
            'arrayfetch'    => "\CodingAvenue\Proof\Nodes\Filter\Rule\DataType\Arrayfetch",
            'array'         => "\CodingAvenue\Proof\Nodes\Filter\Rule\DataType\Array_",
            'echo'          => "\CodingAvenue\Proof\Nodes\Filter\Rule\Construct\Echo_"
        );
    }
}
