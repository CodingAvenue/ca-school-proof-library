<?php

use PHPUnit\Framework\TestCase;
use CodingAvenue\Proof\Nodes\Filter\Rule\Operator\Comparison\NotEqual;

class NotEqualRuleTest extends TestCase
{
    public function testInstance()
    {
        $NotEqual = new NotEqual(array(), true);

        $this->assertInstanceOf(NotEqual::class, $NotEqual, "\$NotEqual is an instance of the NotEqual class");
    }

    public function testGetRule()
    {
        $NotEqual = new NotEqual(array(), true);

        $this->assertInternalType('callable', $NotEqual->getRule(), "GetRule returns a callback");
    }

    public function testCallback()
    {
        $left = new \PhpParser\Node\Scalar\LNumber(1, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));
        $right = new \PhpParser\Node\Scalar\LNumber(2, array('startLine' => 1, 'endLine' => 1, 'kind' => 10));        
        $NotNode = new \PhpParser\Node\Expr\BinaryOp\NotEqual($left, $right, array('startLine' => 1, 'endLine' => 1));

        $NotEqual = new NotEqual(array(), true);
        $rule = $NotEqual->getRule();
        $this->assertEquals(true, $rule($NotNode), "The callback returns true");
    }

    public function testException()
    {
        $this->expectException(Exception::class);

        $NotEqual = new NotEqual(array('unknown' => 'name'), true);
    }
}
