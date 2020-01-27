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
            'assign-ref'    => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Assignment\AssignRef",
            'increment'     => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Increment",
            'decrement'     => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Decrement",
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
            'bool-and'      => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Logical\BooleanAnd",
            'bool-or'       => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Logical\BooleanOr",
            'bool-not'      => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Logical\BooleanNot",
            'logical-and'   => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Logical\LogicalAnd",
            'logical-or'    => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Logical\LogicalOr",
            'logical-xor'   => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Logical\LogicalXor",            
            'subtraction'   => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\BinaryOp\Subtraction",
            'pow'           => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\BinaryOp\Pow",
            'multiplication' => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\BinaryOp\Multiplication",
            'modulo'        => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\BinaryOp\Modulo",
            'division'      => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\BinaryOp\Division",
            'addition'      => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\BinaryOp\Addition",
            'assign-subtraction'    => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\AssignOp\Subtraction",
            'assign-pow'            => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\AssignOp\Pow",
            'assign-multiplication' => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\AssignOp\Multiplication",
            'assign-modulo'         => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\AssignOp\Modulo",
            'assign-division'       => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\AssignOp\Division",
            'assign-addition'       => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\AssignOp\Addition",
            'bitwise-and'   => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Bitwise\BitwiseAnd",
            'bitwise-or'    => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Bitwise\BitwiseOr",
            'bitwise-xor'   => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Bitwise\BitwiseXor",
            'bitwise-not'   => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Bitwise\BitwiseNot",
            'shiftleft'     => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Bitwise\ShiftLeft",
            'shiftright'    => "\CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Bitwise\ShiftRight",
            'call'          => "\CodingAvenue\Proof\Nodes\Filter\Rule\Function_\Call",
            'function'      => "\CodingAvenue\Proof\Nodes\Filter\Rule\Function_\Function_",
            'anonymous'     => "\CodingAvenue\Proof\Nodes\Filter\Rule\Function_\Closure", 
            'param'         => "\CodingAvenue\Proof\Nodes\Filter\Rule\Function_\Param_",
            'args'          => "\CodingAvenue\Proof\Nodes\Filter\Rule\Function_\Args_",                      
            'string'        => "\CodingAvenue\Proof\Nodes\Filter\Rule\DataType\String_",
            'arrayfetch'    => "\CodingAvenue\Proof\Nodes\Filter\Rule\DataType\Arrayfetch",
            'array'         => "\CodingAvenue\Proof\Nodes\Filter\Rule\DataType\Array_",
            'echo'          => "\CodingAvenue\Proof\Nodes\Filter\Rule\Construct\Echo_",
            'return'        => "\CodingAvenue\Proof\Nodes\Filter\Rule\Construct\Return_",
            'continue'      => "\CodingAvenue\Proof\Nodes\Filter\Rule\Construct\Continue_",
            'if'            => "\CodingAvenue\Proof\Nodes\Filter\Rule\Construct\If_",
            'else'          => "\CodingAvenue\Proof\Nodes\Filter\Rule\Construct\Else_",
            'elseif'        => "\CodingAvenue\Proof\Nodes\Filter\Rule\Construct\ElseIf_",
            'switch'        => "\CodingAvenue\Proof\Nodes\Filter\Rule\Construct\Switch_",
            'case'          => "\CodingAvenue\Proof\Nodes\Filter\Rule\Construct\Case_",
            'break'         => "\CodingAvenue\Proof\Nodes\Filter\Rule\Construct\Break_",
            'default'       => "\CodingAvenue\Proof\Nodes\Filter\Rule\Construct\CaseDefault",
            'while'         => "\CodingAvenue\Proof\Nodes\Filter\Rule\Construct\While_",
            'do-while'      => "\CodingAvenue\Proof\Nodes\Filter\Rule\Construct\DoWhile",
            'for'           => "\CodingAvenue\Proof\Nodes\Filter\Rule\Construct\For_",
            'foreach'       => "\CodingAvenue\Proof\Nodes\Filter\Rule\Construct\Foreach_",
            'new'           => "\CodingAvenue\Proof\Nodes\Filter\Rule\Construct\New_",
            'include'       => "CodingAvenue\Proof\Nodes\Filter\Rule\Construct\Include_",
            'class'         => "\CodingAvenue\Proof\Nodes\Filter\Rule\Class_\Class_",
            'use'           => "\CodingAvenue\Proof\Nodes\Filter\Rule\Class_\Use_",
            'namespace'     => "\CodingAvenue\Proof\Nodes\Filter\Rule\Class_\Namespace_",
            'interface'     => "\CodingAvenue\Proof\Nodes\Filter\Rule\Class_\Interface_",
            'static-call'   => "\CodingAvenue\Proof\Nodes\Filter\Rule\Class_\StaticCall",
            'property'      => "\CodingAvenue\Proof\Nodes\Filter\Rule\Class_\Property_",
            'property-call' => "\CodingAvenue\Proof\Nodes\Filter\Rule\Class_\PropertyCall",
            'instantiate'   => "\CodingAvenue\Proof\Nodes\Filter\Rule\Class_\Instantiate_",
            'method-call'   => "\CodingAvenue\Proof\Nodes\Filter\Rule\Class_\MethodCall",
            'const'         => "\CodingAvenue\Proof\Nodes\Filter\Rule\Class_\Const_",
            'const-fetch'   => "\CodingAvenue\Proof\Nodes\Filter\Rule\Class_\ConstFetch",
            'static-prop-fetch' => "\CodingAvenue\Proof\Nodes\Filter\Rule\Class_\StaticPropFetch",          
            'method'        => "\CodingAvenue\Proof\Nodes\Filter\Rule\Function_\Method_"                    
        );
    }
}
