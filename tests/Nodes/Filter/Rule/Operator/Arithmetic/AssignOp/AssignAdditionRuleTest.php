<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\AssignOp\Addition;

class AssignAdditionRuleTest extends TestCase
{
    public function testInstance()
    {
        $Addition = new Addition(array(), true);

        $this->assertInstanceOf(Addition::class, $Addition, "\$Addition is an instance of the Addition class");
    }

    public function testGetRule()
    {
        $Addition = new Addition(array(), true);

        $this->assertInternalType('callable', $Addition->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $variable = new \PhpParser\Node\Expr\Variable('num', array());
        $initialValue = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $assign = new \PhpParser\Node\Expr\Assign($variable, $initialValue);

        $nextValue = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));

        $assignAddition = new \PhpParser\Node\Expr\AssignOp\Plus($variable, $nextValue);

        $Addition = new Addition(array(), true);
        $rule = $Addition->getRule();
        $this->assertEquals(true, $rule($assignAddition), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $Addition = new Addition(array('unknown' => 'name'), true);
    }
}
