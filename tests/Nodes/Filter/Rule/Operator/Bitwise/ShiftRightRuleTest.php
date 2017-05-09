<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Bitwise\ShiftRight;

class ShiftRightRuleTest extends TestCase
{
    public function testInstance()
    {
        $ShiftRight = new ShiftRight(array(), true);

        $this->assertInstanceOf(ShiftRight::class, $ShiftRight, "\$ShiftRight is an instance of the ShiftRight class");
    }

    public function testGetRule()
    {
        $ShiftRight = new ShiftRight(array(), true);

        $this->assertInternalType('callable', $ShiftRight->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $NotNode = new \PhpParser\Node\Expr\BinaryOp\ShiftRight($left, $right, array('startLine' => 1, 'endLine' => 1));

        $ShiftRight = new ShiftRight(array(), true);
        $rule = $ShiftRight->getRule();
        $this->assertEquals(true, $rule($NotNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $ShiftRight = new ShiftRight(array('unknown' => 'name'), true);
    }
}
