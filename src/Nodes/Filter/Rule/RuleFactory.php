<?php

namespace CodingAvenue\Proof\Nodes\Filter\Rule;

/**
 * Factory class for all Rule class.
 * Maps a rule name to it's Rule class
 * Returns the instance of that Rule class.
 * throws an Exception if no rule is found
 */
class RuleFactory
{
    /**
     * Main Factory class method, given the name returns the instance of the Rule that correspond to the name.
     *
     * @param string $name the name of the rule
     * @param array $filters the filters to be passed to the Rule constructor
     * @param bool $traverse if this rule will be applied to it's children only or not
     *
     * @return the instance of the Rule found
     * @throws Exception if no Rule class is found.
     */
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
            'bitwise-and'   => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Bitwise\BitwiseAnd",
            'bitwise-or'    => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Bitwise\BitwiseOr",
            'bitwise-xor'   => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Bitwise\BitwiseXor",
            'bitwise-not'   => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Bitwise\BitwiseNot",
            'shiftleft'     => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Bitwise\ShiftLeft",
            'shiftright'    => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Bitwise\ShiftRight",
            'call'          => "\CodingAvenue\Proof\Nodes\Filter\Rule\Function_\Call",
            'function'      => "\CodingAvenue\Proof\Nodes\Filter\Rule\Function_\Function_",
            'string'        => "\CodingAvenue\Proof\Nodes\Filter\Rule\DataType\String_",
            'arrayfetch'    => "\CodingAvenue\Proof\Nodes\Filter\Rule\DataType\Arrayfetch",
            'array'         => "\CodingAvenue\Proof\Nodes\Filter\Rule\DataType\Array_",
            'echo'          => "\CodingAvenue\Proof\Nodes\Filter\Rule\Construct\Echo_",
            'return'        => "\CodingAvenue\Proof\Nodes\Filter\Rule\Construct\Return_"
        );
    }
}
