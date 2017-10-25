<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Logical\LogicalAnd;

class LogicalAndRuleTest extends TestCase
{
    public function testInstance()
    {
        $logicalAnd = new LogicalAnd(array(), true);

        $this->assertInstanceOf(LogicalAnd::class, $logicalAnd, "\$logicalAnd is an instance of the LogicalAnd class");
    }

    public function testGetRule()
    {
        $logicalAnd = new LogicalAnd(array(), true);

        $this->assertInternalType('callable', $logicalAnd->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $logicalAndNode = new \PhpParser\Node\Expr\BinaryOp\LogicalAnd($left, $right, array('startLine' => 1, 'endLine' => 1));

        $logicalAnd = new LogicalAnd(array(), true);
        $rule = $logicalAnd->getRule();
        $this->assertEquals(true, $rule($logicalAndNode), "The callback returns true");
        $this->assertEquals(false, $rule($left), "The callback returns false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $logicalAnd = new LogicalAnd(array('unknown' => 'name'), true);
    }
}
