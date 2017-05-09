<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\LessEqual;

class LessEqualRuleTest extends TestCase
{
    public function testInstance()
    {
        $lessEqual = new LessEqual(array(), true);

        $this->assertInstanceOf(LessEqual::class, $lessEqual, "\$lessEqual is an instance of the LessEqual class");
    }

    public function testGetRule()
    {
        $lessEqual = new LessEqual(array(), true);

        $this->assertInternalType('callable', $lessEqual->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $lessNode = new \PhpParser\Node\Expr\BinaryOp\SmallerOrEqual($left, $right, array('startLine' => 1, 'endLine' => 1));

        $lessEqual = new LessEqual(array(), true);
        $rule = $lessEqual->getRule();
        $this->assertEquals(true, $rule($lessNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $lessEqual = new LessEqual(array('unknown' => 'name'), true);
    }
}
