<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\AssignOp\Subtraction;

class AssignSubtractionRuleTest extends TestCase
{
    public function testInstance()
    {
        $subtraction = new Subtraction(array(), true);

        $this->assertInstanceOf(Subtraction::class, $subtraction, "\$subtraction is an instance of the Subtraction class");
    }

    public function testGetRule()
    {
        $subtraction = new Subtraction(array(), true);

        $this->assertInternalType('callable', $subtraction->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $variable = new \PhpParser\Node\Expr\Variable('num', array());
        $initialValue = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $assign = new \PhpParser\Node\Expr\Assign($variable, $initialValue);

        $nextValue = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));

        $assignSubtraction = new \PhpParser\Node\Expr\AssignOp\Minus($variable, $nextValue);

        $subtraction = new Subtraction(array(), true);
        $rule = $subtraction->getRule();
        $this->assertEquals(true, $rule($assignSubtraction), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $subtraction = new Subtraction(array('unknown' => 'name'), true);
    }
}
