<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Logical\LogicalOr;

class LogicalOrRuleTest extends TestCase
{
    public function testInstance()
    {
        $logicalOr = new LogicalOr(array(), true);

        $this->assertInstanceOf(LogicalOr::class, $logicalOr, "\$logicalOr is an instance of the LogicalOr class");
    }

    public function testGetRule()
    {
        $logicalOr = new LogicalOr(array(), true);

        $this->assertInternalType('callable', $logicalOr->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $logicalOrNode = new \PhpParser\Node\Expr\BinaryOp\LogicalOr($left, $right, array('startLine' => 1, 'endLine' => 1));

        $logicalOr = new LogicalOr(array(), true);
        $rule = $logicalOr->getRule();
        $this->assertEquals(true, $rule($logicalOrNode), "The callback returns true");
        $this->assertEquals(false, $rule($left), "The callback returns false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $logicalOr = new LogicalOr(array('unknown' => 'name'), true);
    }
}
