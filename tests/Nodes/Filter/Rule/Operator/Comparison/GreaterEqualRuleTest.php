<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\GreaterEqual;

class GreaterEqualRuleTest extends TestCase
{
    public function testInstance()
    {
        $greaterEqual = new GreaterEqual(array(), true);

        $this->assertInstanceOf(GreaterEqual::class, $greaterEqual, "\$greaterEqual is an instance of the GreaterEqual class");
    }

    public function testGetRule()
    {
        $greaterEqual = new GreaterEqual(array(), true);

        $this->assertInternalType('callable', $greaterEqual->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $greaterNode = new \PhpParser\Node\Expr\BinaryOp\GreaterOrEqual($left, $right, array('startLine' => 1, 'endLine' => 1));

        $greater = new GreaterEqual(array(), true);
        $rule = $greater->getRule();
        $this->assertEquals(true, $rule($greaterNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $greater = new GreaterEqual(array('unknown' => 'name'), true);
    }
}
