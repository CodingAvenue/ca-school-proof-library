<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Arithmetic\Subtraction;

class SubtractionRuleTest extends TestCase
{
    public function testInstance()
    {
        $Subtraction = new Subtraction(array(), true);

        $this->assertInstanceOf(Subtraction::class, $Subtraction, "\$Subtraction is an instance of the Subtraction class");
    }

    public function testGetRule()
    {
        $Subtraction = new Subtraction(array(), true);

        $this->assertInternalType('callable', $Subtraction->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $SubtractionNode = new \PhpParser\Node\Expr\BinaryOp\Minus($left, $right, array('startLine' => 1, 'endLine' => 1));

        $Subtraction = new Subtraction(array(), true);
        $rule = $Subtraction->getRule();
        $this->assertEquals(true, $rule($SubtractionNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $Subtraction = new Subtraction(array('unknown' => 'name'), true);
    }
}
