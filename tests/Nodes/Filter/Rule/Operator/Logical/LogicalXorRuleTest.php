<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Logical\LogicalXor;

class LogicalXorRuleTest extends TestCase
{
    public function testInstance()
    {
        $logicalXor = new LogicalXor(array(), true);

        $this->assertInstanceOf(LogicalXor::class, $logicalXor, "\$logicalXor is an instance of the LogicalXor class");
    }

    public function testGetRule()
    {
        $logicalXor = new LogicalXor(array(), true);

        $this->assertInternalType('callable', $logicalXor->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $logicalXorNode = new \PhpParser\Node\Expr\BinaryOp\LogicalXor($left, $right, array('startLine' => 1, 'endLine' => 1));

        $logicalXor = new LogicalXor(array(), true);
        $rule = $logicalXor->getRule();
        $this->assertEquals(true, $rule($logicalXorNode), "The callback returns true");
        $this->assertEquals(false, $rule($left), "The callback returns false");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $logicalXor = new LogicalXor(array('unknown' => 'name'), true);
    }
}
