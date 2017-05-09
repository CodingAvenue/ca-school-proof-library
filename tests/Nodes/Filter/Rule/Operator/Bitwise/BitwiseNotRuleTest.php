<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Bitwise\BitwiseNot;

class BitwiseNotRuleTest extends TestCase
{
    public function testInstance()
    {
        $BitwiseNot = new BitwiseNot(array(), true);

        $this->assertInstanceOf(BitwiseNot::class, $BitwiseNot, "\$BitwiseNot is an instance of the BitwiseNot class");
    }

    public function testGetRule()
    {
        $BitwiseNot = new BitwiseNot(array(), true);

        $this->assertInternalType('callable', $BitwiseNot->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $NotNode = new \PhpParser\Node\Expr\BitwiseNot($left, array('startLine' => 1, 'endLine' => 1));

        $BitwiseNot = new BitwiseNot(array(), true);
        $rule = $BitwiseNot->getRule();
        $this->assertEquals(true, $rule($NotNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $BitwiseNot = new BitwiseNot(array('unknown' => 'name'), true);
    }
}
