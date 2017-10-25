<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\AssignOp\Multiplication;

class AssignMultiplicationRuleTest extends TestCase
{
    public function testInstance()
    {
        $Multiplication = new Multiplication(array(), true);

        $this->assertInstanceOf(Multiplication::class, $Multiplication, "\$Multiplication is an instance of the Multiplication class");
    }

    public function testGetRule()
    {
        $Multiplication = new Multiplication(array(), true);

        $this->assertInternalType('callable', $Multiplication->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $variable = new \PhpParser\Node\Expr\Variable('num', array());
        $initialValue = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $assign = new \PhpParser\Node\Expr\Assign($variable, $initialValue);

        $nextValue = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));

        $assignMultiplication = new \PhpParser\Node\Expr\AssignOp\Mul($variable, $nextValue);

        $Multiplication = new Multiplication(array(), true);
        $rule = $Multiplication->getRule();
        $this->assertEquals(true, $rule($assignMultiplication), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $Multiplication = new Multiplication(array('unknown' => 'name'), true);
    }
}
