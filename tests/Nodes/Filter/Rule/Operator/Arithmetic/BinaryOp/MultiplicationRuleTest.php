<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\BinaryOp\Multiplication;

class MultiplicationRuleTest extends TestCase
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
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $MultiplicationNode = new \PhpParser\Node\Expr\BinaryOp\Mul($left, $right, array('startLine' => 1, 'endLine' => 1));

        $Multiplication = new Multiplication(array(), true);
        $rule = $Multiplication->getRule();
        $this->assertEquals(true, $rule($MultiplicationNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $Multiplication = new Multiplication(array('unknown' => 'name'), true);
    }
}
