<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\AssignOp\Division;

class AssignDivisionRuleTest extends TestCase
{
    public function testInstance()
    {
        $Division = new Division(array(), true);

        $this->assertInstanceOf(Division::class, $Division, "\$Division is an instance of the Division class");
    }

    public function testGetRule()
    {
        $Division = new Division(array(), true);

        $this->assertInternalType('callable', $Division->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $variable = new \PhpParser\Node\Expr\Variable('num', array());
        $initialValue = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $assign = new \PhpParser\Node\Expr\Assign($variable, $initialValue);

        $nextValue = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));

        $assignDivision = new \PhpParser\Node\Expr\AssignOp\Div($variable, $nextValue);

        $Division = new Division(array(), true);
        $rule = $Division->getRule();
        $this->assertEquals(true, $rule($assignDivision), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $Division = new Division(array('unknown' => 'name'), true);
    }
}
